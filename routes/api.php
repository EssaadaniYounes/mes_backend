<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasePostController;
use App\Http\Controllers\ClasseController;
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
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('users', UserController::class);
    Route::resource('time-tables', TimeTableController::class);
    Route::resource('classes', ClasseController::class);


    Route::get('auth-user',[UserController::class,'getAuthenticatedUser']);

    Route::post('create-users',[UserController::class,'createUsers']);
    Route::post('create-users-excel',[UserController::class,'createFromExcel']);


    //uploads
     Route::post('time-tables/upload',[TimeTableController::class,'uploadFile']);
});
