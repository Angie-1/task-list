<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskMail;

class DateTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'date:time {task} {date} {name} {email}';

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
        //send email
         $params = [
            "name"=>$this->argument("name"),
            "task"=>$this->argument("task"),
            "date"=>$this->argument("date"),
            "subject"=>"Reminder",
        ];
        // dd($email);
        Mail::to($this->argument("email"))->send(new TaskMail($params));
        return true;
    }
}
