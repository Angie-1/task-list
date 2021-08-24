<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Task;
use App\Mail\TaskMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use SendGrid\Mail\Mail;
use Illuminate\Support\Facades\Mail;
use SendGrid\Mail\Personalization;
use SendGrid\Mail\To;

class SendEmailController extends Controller
{
    

    public function create(){
        $admin = auth()->user();
        $users = User::Where("id","!=",$admin->id)->get();
       $tasks = Task::orderBy('title')->Where("user_id", $admin->id)->get();
        //$users = User::orderBy('name')->get();
        return view("Emails.create",compact("admin","users","tasks"));
    }

    public function send(Request $data){
        $user = auth()->user();
        // dd($user->email);
        $task = Task::find($data->tasks);
        $params = [
            "name"=>$user->name,
            "subject"=>$data->subject,
            "task"=>$task->title,
            "date"=>date("Y-m-d"),
        ];
        // dd($email);
        Mail::to($user->email)->send(new TaskMail($params));
        return ["Email Sent"];
     
    }

    // public function send_email(Request $data){
    //     $request = (object)[
    //         "id"=>1,
    //         "email_to"=>auth()->user()->id,
    //         "subject"=>$data->subject,
    //         "tasks"=>$data->tasks,
    //     ];
    //     $email = SendEmailController::email($request);
    //     return $email;
    // }

    public static function email($request)
    {
        // dd($request->tasks);
        $sender =User::find($request->id);
        $client =User::find($request->email_to);
        $sendgrid = new \SendGrid(env('SENDGRID_KEY'));
        $templateid =env('SENDGRID_DYNAMIC_TEMPLATE_SINGLE_MAIL');
        $email    = new Mail();
        // $email->setFrom($sender->email,$sender->name);
        // $email->addTo($client->email,$client->name);
        $email->setFrom($sender->email,$sender->name);
        $email->addTo($client->email,$client->name);
        $sentdate=Carbon::now()->timezone(env('TIMEZONE'))->format('d M, yy g:i A');
        $substitutions = [
            "name" => $client->name,
            "subject"=>$request->subject,
            "tasks" => $request->tasks,
            // "fromname" => $sender->name,
            // "sentdate" => $sentdate,
        ];
        $email->addDynamicTemplateDatas($substitutions);
        //Send The Mail
        try
        {
            $email->setTemplateId($templateid);
            $response = $sendgrid->send($email);
            if($response->statusCode() == "202")
            {
                // return redirect()->back()->with("success","Email sent Successfully");
                return ["Email sent Successfully"];
            }
            else
            {
                return response()->json(['result_code'=>1,'message'=>"Failed:\n".$response->body()."\n",'data'=>$request->all()]);
            }
        }
        catch (\Exception $e)
        {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return response()->json(['result_code'=>1,'message'=>"Failed:\n".$e->getMessage()."\n",'data'=>$request->all()]);
        }
    }

    public static function many(Request $request)
    {
//        $rules = [
//            'id' => ['required'],
//            'role_id' => ['required'],
//            'subject' => ['required'],
//            'message' => ['required'],
//        ];
//        $validator = Validator::make($request->all(), $rules);
//        if ($validator->fails()) {
//            $message = $validator->errors()->first();
//            return ['result_code' => 1, 'message' => $message, 'data' => $request->all()];
//        }
        $sender = User::find($request->id);
        $to = [];
        $users = User::all();
        foreach ($users as $user){
            if ($user->role->id != 1){
                $to[] = ["name"=>"$user->name","email"=>"$user->email"];
            }
        }
        $sentdate=Carbon::now()->timezone(env('TIMEZONE'))->format('d M, Y g:i A');
        $sendgrid = new \SendGrid(env('SENDGRID_KEY'));
        $templateid =env('SENDGRID_DYNAMIC_TEMPLATE_SINGLE_MAIL');
        $email    = new Mail();
        $email->addTo("notifications@gmail.com", env('MAIL_NOTIFICATION_NAME'));
        $email->setFrom(env('MAIL_NOTIFICATION_ADDRESS'),env('MAIL_NOTIFICATION_NAME'));
        $substitutions = [
            "subject"=>$request->subject,
            "body" => $request->message,
            "toname" => $sender->name,
            "fromname" => $sender->name,
            "sentdate" => $sentdate,
        ];
        $email->addDynamicTemplateDatas($substitutions);
        $email_data = json_decode(json_encode($to));
        //Sendgrid Has a Limit of 1000 Emails per APi Call so Chunk
        $email_data_chunk = array_chunk($email_data, 900);
        $emails_sent=0;
        $email->setTemplateId($templateid);
        foreach ($email_data_chunk as $the_email_data) {
            $res = EmailController::postSendgridEmailToMany($the_email_data, $request,$sentdate,$email,$sender,$sendgrid);
            $resObj= json_decode($res->getContent());
            if($resObj->result_code ==0)
            {
                $emails_sent=$emails_sent+$resObj->data;
            }
        }
        if($emails_sent > 0)
        {
            //Success
            return redirect()->back()->with("success","Emails Sent Successfully");
        }
        else
        {
            //Failed
            return response()->json(['result_code'=>1,'message'=>"Failed. Could not send emails. Try again and contact admin if problem continues",'data'=>$request->all()]);
        }
    }
    
    public static function postSendgridEmailToMany($email_data,$request,$sentdate,$email,$sender,$sendgrid)
    {
        $tos=[];
        $emails_sent=sizeOf($email_data);
        for ($i=0; $i< sizeOf($email_data); $i++)
        {
            $person= (object) $email_data[$i];
            $person_array = [];
            $person_array[$person->email]=$person->name;
            $tos[$person->email]= $person->name;
            $to= new To($person->email,$person->name);
            $personalization= new Personalization;
            $personalization->addTo($to);
            $personalization->addSubstitution("toname", $person->name);
            $personalization->addSubstitution("fromname", $sender->name);
            $personalization->addSubstitution("subject", $request->subject);
            $personalization->addSubstitution("sentdate", $sentdate);
            $personalization->addSubstitution("body", $request->message);
            $email->addPersonalization( $personalization );
        }
        try
        {
            $response = $sendgrid->send($email);
            if($response->statusCode() == "202")
            {
                return response()->json(['result_code'=>0,'message'=>"Success",'data'=>$emails_sent]);
            }
            else
            {
                return response()->json(['result_code'=>1,'message'=>"Failed:\n".$response->body()."\n",'data'=>$request->all()]);
            }

        }
        catch (\Exception $e)
        {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            return response()->json(['result_code'=>1,'message'=>"Failed:\n".$e->getMessage()."\n",'data'=>$request->all()]);
        }
    }
}
