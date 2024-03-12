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

// Sanctum automatically redirects you to a 'login' route if you dont put 'Accept: application/json' in the header of the request
// So to get a 401 response even if you forget the header i made this route whos only purpose is to return a 401 response
Route::get('/login', [AuthController::class, 'unauthorized'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // AUTH
    Route::get('/me', [AuthController::class, 'me']);

    // AVATARS
    Route::apiResource('avatars', AvatarController::class);
    
    // BADGES
    Route::apiResource('badges', BadgeController::class); 

    // CHALLENGES
    Route::apiResource('challenges', ChallengeController::class);
    
    // DAILY CHALLENGE STEPS
    Route::apiResource('daily-challenges-steps', DailyChallengeStepsController::class);

    // DAILY STEPS
    Route::post('daily-steps', [DailyStepsController::class, 'storeOrUpdate']);
    Route::get('daily-steps/user/all', [DailyStepsController::class, 'showAllUserSteps']);
    Route::get('daily-steps/user/last', [DailyStepsController::class, 'lastUserSteps']);
    Route::get('daily-steps/user/atdate', [DailyStepsController::class, 'showUserStepsAtDate']);

    // HEALTH MESSAGES
    Route::get('health-messages', [HealthMessagesController::class, 'index']);

    // USERS
    Route::apiResource('users', UsersController::class);

    // Admin specific routes
    Route::middleware('admin')->group(function () {
        // DAILY STEPS
        Route::get('daily-steps', [DailyStepsController::class, 'index']);
        Route::delete('daily-steps/{id}', [DailyStepsController::class, 'destroy']);

        // HEALTH MESSAGES
        Route::post('health-messages/{id?}', [HealthMessagesController::class, 'createOrUpdate']);
        Route::delete('health-messages/{id}', [HealthMessagesController::class, 'destroy']);

        // USERS IMPORT/EXPORT
        Route::post('/import', [UsersController::class, 'import']);
        Route::post('/export', [UsersController::class, 'export']);
    });
});