<?php

use App\Http\Controllers\API\AvatarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\BadgeController;
use App\Http\Controllers\API\ChallengeController;
use App\Http\Controllers\API\DailyChallengeStepsController;
use App\Http\Controllers\API\DailyStepsController;
use App\Http\Controllers\API\HealthMessagesController;
use App\Http\Controllers\API\UsersController;
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
Route::get('/login', [AuthController::class, 'unauthorized'])->name('login');

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::resource('badges', BadgeController::class);
// });

Route::resource('badges', BadgeController::class);
Route::resource('avatars', AvatarController::class);
Route::resource('challenges', ChallengeController::class);
Route::resource('daily-challenges-steps', DailyChallengeStepsController::class);
Route::resource('daily-steps', DailyStepsController::class);
Route::resource('health-messages', HealthMessagesController::class);
Route::resource('users', UsersController::class);

// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::resource('badges', BadgeController::class);
//     Route::resource('avatars', AvatarController::class);
//     Route::resource('challenges', ChallengeController::class);

//     Route::resource('daily-challenges-steps', DailyChallengeStepsController::class);
//     Route::resource('daily-steps', DailyStepsController::class);
//     Route::resource('health-messages', HealthMessagesController::class);
//     Route::resource('users', UsersController::class);
// });

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
// Sanctum automatically redirects you to a 'login' route if you dont put 'Accept: application/json' in the header of the request
// So to get a 401 response even if you forget the header i made this route whos only purpose is to return a 401 response
Route::get('/login', [AuthController::class, 'unauthorized'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'me'])->setFallback(true);


