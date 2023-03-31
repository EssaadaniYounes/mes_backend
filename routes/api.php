<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasePostController;
use App\Http\Controllers\RoleController;
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


    Route::get('auth-user',[UserController::class,'getAuthenticatedUser']);

    Route::post('create-users',[UserController::class,'createUsers']);

});
