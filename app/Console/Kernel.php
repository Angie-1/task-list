<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendReminder;
use App\Console\Commands\DateTime;
use App\Models\User;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendReminder::class,
        DateTime::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $users = User::all();
       $test = [];
       foreach($users as $user){
            foreach($user->tasks as $task){
                $date = date("i-H-d-m-N",strtotime("-1 day",strtotime($task->datetime)));
                $date = explode("-",$date);
                $schedule->command("date:time",[$task->title,$task->datetime,$user->name,$user->email])
                ->cron("$date[0] $date[1] $date[2] $date[3] $date[4]");
            } 
        }
            // $schedule->command("send:reminder",[$user->id,$tasks])->everyMinute(); 
           
        $user = User::find(2);
        $schedule->command("send:reminder",[$user->name, $user->email])->dailyAt("13:40");
    
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
