<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;


class TaskController extends Controller
{
     public function login(){
        return view('auth.login');
    }

    
     public function addTask()
    {
        return view('add-task');
    
    }

    //add post submit 
   public function addTaskSubmit(Request $request){
    //    dd($request->all());
       $user = auth()->user();
        $task = new Task();
        $task ->user_id = $user->id;
       $task ->title = $request->title;
        $task ->body = $request->body;
        $task ->save();
       return back()->with('task_created', 'task has been created successfully');
    }

   // public function addTaskSubmit(Request $request)
   // {
      //  DB::table('tasks')->insert([
      //      'title'=> $request->title,
       //     'body'=> $request->body
      //  ]);
      //  return back()->with('task_created','Task has been created successfully');

   // } 
   public function getAllTasks(){
        $user = auth()->user();
        // $tasks = Task::orderBy('id','DESC')->where("user_id",$user->id)->get();
        $tasks = null;
        if ($user->role_id == 1) {
            $tasks = Task::all();
        }else{
            $tasks = $user->tasks;
        }
        // dd($user);
       return view('tasks',compact('tasks'));
   }

  // public function getAllTasks()
//{
   //    $tasks= DB::table('tasks')->get();
    //  return view('tasks', compact('tasks'));
 //}

   public function deleteTask($id){
        Task::where('id',$id)->delete();
        return back()->with('task_deleted','task has been deleted successfully');

    }

   // public function deleteTask($id)
   // {
     //   DB::table('tasks')->where('id',$id)->delete();  
    //    return back()->with('task_deleted','task has been deleted');
   // }

   //editpost
    public  function editTask($id){
        $task = Task::find($id);
        return view('edit-task',compact('task'));
    }
    //editpostbutton
    public function updateTask(Request $request){
        $task = Post::find($request->id);
        $task->title=$request->title;
        $task->body=$request->body;
        $task->save();
        return back()->with('task_updated','task has been updated successfully');
    }

    //public function editTask($id)
    //{
        //$task = DB::table('tasks')->where('id', $id)->first();
        //return view('edit-task',compact('task'));
   // }

    //public function updateTask(Request $request)
    //{
      //  DB::table('tasks')->where('id', $request->id)->update([
      //      'title'=> $request->title,
    //     'body'=> $request->body
        //]); 
        //return back()->with('task_updated', 'task updated successfully');
    //} 



   

    public function register(){
        return view('auth.register');
    }

    public function save(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:admins',
            'password'=>'required|min:3|max:12'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $save = $user->save();
        if($save){
            return back()->with('success','new user has been successfully added to database');
        }else{
            return back()->with('fail','something went wrong, try again later');
        }

    }

    public function check(Request $request){
        // dd($request->all());
        $user = $request->all();
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:5|max:12'
        ]);
    
    $userInfo = User::where('email','=', $request->email)->first();
    if(!$userInfo){
        return back()->with('fail', 'we do not recognize your email address');
    }else{
      if (Hash::check($request->password, $userInfo->password)){
          $request->session()->put('LoggedUser', $userInfo->id);
          $result = Auth::attempt(['email'=>$user['email'],'password'=>$user['password']]);
        //  dd($result); 
          return redirect('/tasks');
    }else{
        return back()->with('fail','incorrect password');
    }
}

   
    }
    public function logout(){
        if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            Auth::logout();
            return redirect('/auth/login');
        }
    }

}






    