<?php

use App\Http\Controllers\AuthController;
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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
// Sanctum automatically redirects you to a 'login' route if you dont put 'Accept: application/json' in the header of the request
// So to get a 401 response even if you forget the header i made this route whos only purpose is to return a 401 response
Route::get('/login', [AuthController::class, 'unauthorized'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me'])->setFallback(true);

// Route::group(['prefix' => 'api'], function () {
//     Route::post('login', 'AuthController@login');
//     Route::post('register', 'AuthController@register');
//     Route::get('user', 'UserController@details');
//     Route::resource('challenges', 'ChallengeController');
//     Route::resource('badges', 'BadgeController');
//     Route::resource('daily_steps', 'DailyStepController');
//     Route::resource('avatars', 'AvatarController');
//     Route::resource('jobs', 'JobController');
//     Route::resource('health_messages', 'HealthMessageController');
// });