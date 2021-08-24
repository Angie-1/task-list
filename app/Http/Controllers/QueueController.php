<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TaskMail;
use Illuminate\Support\Facades\Mail;

class QueueController extends Controller
{
    public function index(){
        $user = auth()->user();
        $tasks = $user->tasks;
        $params = [
            "name"=>$user->name,
            "subject"=>"Test Mail",
        ];
        // dd($email);
        Mail::to($user->email)->send(new TaskMail($params));
        return ["Email Sent"];
    }
}
