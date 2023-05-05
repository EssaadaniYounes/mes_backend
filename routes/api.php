<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasePostController;
use App\Http\Controllers\ClasseController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TimeTableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::middleware('auth:api')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('posts', BasePostController::class);
    Route::resource('courses', PostController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('users', UserController::class);
    Route::resource('time-tables', TimeTableController::class);
    Route::resource('results', ResultController::class);
    Route::resource('classes', ClasseController::class);
    Route::resource('events', EventController::class);
    Route::resource('conversations', ConversationController::class);
    Route::resource('messages', MessageController::class);


    Route::get('auth-user',[UserController::class,'getAuthenticatedUser']);
    Route::get('profile',[UserController::class,'getProfile']);
    Route::get('users-suggestions',[UserController::class,'getSuggestions']);
    Route::get('results/result/current',[ResultController::class,'getCurrentUserResult']);
    Route::get('time-table/current',[TimeTableController::class,'getCurrentUserResult']);
    Route::get('events/event/{type}',[EventController::class,'getByType']);
    Route::get('conversation-messages/{id}',[ConversationController::class,'getMessages']);


    Route::post('create-users',[UserController::class,'createUsers']);
    Route::post('create-users-excel',[UserController::class,'createFromExcel']);
     Route::post('mark-messages-read/{id}',[ConversationController::class,'markRead']);


    //uploads
     Route::post('time-tables/upload',[TimeTableController::class,'uploadFile']);
     Route::post('results/upload',[ResultController::class,'uploadFile']);
     Route::post('course-attachments',[PostController::class,'uploadAttachments']);
     Route::post('event-attachments',[EventController::class,'uploadAttachments']);


});
