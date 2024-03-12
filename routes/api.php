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
    Route::get('avatars', [AvatarController::class, 'index']);
    Route::get('avatars/{avatarId}', [AvatarController::class, 'show']);
    Route::post('avatars/{avatarId?}', [AvatarController::class, 'createOrUpdate']);
    Route::delete('avatars/{avatarId}', [AvatarController::class, 'destroy']);

    // BADGES
    Route::get('badges', [BadgeController::class, 'index']);
    Route::get('badges/{badgeId}', [BadgeController::class, 'show']);
    Route::post('badges/{badgeId?}', [BadgeController::class, 'createOrUpdate']);
    Route::delete('badges/{badgeId}', [BadgeController::class, 'destroy']);

    // CHALLENGES
    // Route::apiResource('challenges', ChallengeController::class);
    Route::get('challenges', [ChallengeController::class, 'index']);
    Route::get('challenges/{challengeId}', [ChallengeController::class, 'show']);
    Route::post('challenges/{challengeId?}', [ChallengeController::class, 'createOrUpdate']);
    Route::delete('challenges/{challengeId}', [ChallengeController::class, 'destroy']);


    // DAILY CHALLENGE STEPS
    Route::apiResource('daily-challenges-steps', DailyChallengeStepsController::class);

    // DAILY STEPS
    Route::post('daily-steps', [DailyStepsController::class, 'createOrUpdate']);

    // HEALTH MESSAGES
    Route::get('health-messages', [HealthMessagesController::class, 'index']);
    Route::get('health-messages/{healthMessageId}', [HealthMessagesController::class, 'show']);

    // USERS
    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{userId}', [UsersController::class, 'show']);
    Route::post('users/{userId?}', [UsersController::class, 'createOrUpdate']);
    Route::delete('users/{userId}', [UsersController::class, 'destroy']);

    Route::get('users/badges', [UsersController::class, 'showUserBadges']);
    Route::post('users/badges', [UsersController::class, 'addBadge']);
    Route::delete('users/badges/{userId}/{badgeId}', [UsersController::class, 'removeBadge']);

    Route::get('users/daily-steps/all', [UsersController::class, 'showAllUserSteps']);
    Route::get('users/daily-steps/last', [UsersController::class, 'lastUserSteps']);
    Route::get('users/daily-steps/atdate', [UsersController::class, 'showUserStepsAtDate']);


    // Admin specific routes
    Route::middleware('admin')->group(function () {
        // DAILY STEPS
        Route::get('daily-steps', [DailyStepsController::class, 'index']);
        Route::delete('daily-steps/{dailyStepId}', [DailyStepsController::class, 'destroy']);

        // HEALTH MESSAGES
        Route::post('health-messages/{healthMessageId?}', [HealthMessagesController::class, 'createOrUpdate']);
        Route::delete('health-messages/{healthMessageId}', [HealthMessagesController::class, 'destroy']);

        // USERS IMPORT/EXPORT
        Route::post('/import', [UsersController::class, 'import']);
        Route::post('/export', [UsersController::class, 'export']);
    });
});
