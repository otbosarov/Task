<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/register',[UserController::class, 'register']);
Route::post('user/login',[UserController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'],function(){

     Route::put('user/update/{id}',[UserController::class, 'update']);
     Route::get('user_info', [UserController::class, 'user_info']);

     Route::get('task/show',[TaskController::class, 'index']);
     Route::post('task/create',[TaskController::class, 'store']);
     Route::post('task/finish/{id}',[TaskController::class, 'finish']);
     Route::get('project',[TaskController::class, 'project']);
     Route::post('send/task',[TaskController::class, 'sendTaskToParnter']);
     Route::get('for/me/tasks', [TaskController::class, 'getForMeTasks']);
     Route::post('accept/task', [TaskController::class, 'acceptTask']);
     Route::post('rejection/task', [TaskController::class, 'rejectionTask']);


});
