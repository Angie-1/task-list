<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\SendEmailController;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskMail;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder {name} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $to = $this->argument("to");
        // $tasks = $this->argument("tasks");
        // $request = (object)[
        //             "id"=>1,
        //             "email_to"=>$to,
        //             "subject"=>"Task Reminder",
        //             "tasks"=>$tasks,
        //         ];
        // $email = SendEmailController::email($request);
        // return $email;

        // $user =User::find(2);
        // $tasks = $user->tasks;
        $params = [
            "name"=>$this->argument("name"),
            "subject"=>"Test Mail",
        ];
        // dd($email);
        Mail::to($this->argument("email"))->send(new TaskMail($params));
        return ["Email Sent"];
    }
}
