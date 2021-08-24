<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\SendEmailController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::group(['middleware'=>'auth'],function (){
Route::get('/tasks',[TaskController::class, 'getAllTasks'])->name('tasks.getAllTasks');
Route::get('/add-task',[TaskController::class, 'addTask'])->name('tasks.addTask');
Route::post('/add-task',[TaskController::class, 'addTaskSubmit'])->name('tasks.addTaskSubmit');
Route::get('/email',[SendEmailController::class,'create']);
Route::post('/email',[SendEmailController::class,'send_email']);
});
Route::get('/auth/login',[TaskController::class,'login'])->name('login');
Route::get('/auth/register',[TaskController::class,'register'])->name('auth.register');
Route::post('/auth/save',[TaskController::class,'save'])->name('auth.save');
Route::post('/auth/check',[TaskController::class,'check'])->name('auth.check');





Route::get('/delete-task/{id}',[TaskController::class, 'deleteTask'])->name('tasks.delete');
Route::get('/edit-task/{id}',[TaskController::class, 'editTask'])->name('tasks.edit');
Route::post('/update-task',[TaskController::class, 'updateTask'])->name('tasks.update');
Route::get('/auth/logout',[TaskController::class,'logout'])->name('auth.logout');
