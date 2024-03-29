<?php

use App\Http\Controllers\API\AvatarController;
use App\Http\Controllers\API\StatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\BadgeController;
use App\Http\Controllers\API\ChallengeController;
use App\Http\Controllers\API\DailyChallengeStepsController;
use App\Http\Controllers\API\DailyStepsController;
use App\Http\Controllers\API\HealthMessagesController;
use App\Http\Controllers\API\UsersController;
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
Route::get('/stats', [StatController::class, 'index']);
Route::post('/recalculate', [StatController::class, 'recalculate']);

Route::middleware('auth:sanctum')->group(function () {
    // AUTH
    Route::get('/me', [AuthController::class, 'me']);

    // AVATARS
    Route::get('avatars', [AvatarController::class, 'index']);
    Route::get('avatars/{avatarId}', [AvatarController::class, 'show']);

    // BADGES
    Route::get('badges', [BadgeController::class, 'index']);
    Route::get('badges/{badgeId}/withavatar', [BadgeController::class, 'showBadgeWithAvatar']);
    Route::get('badges/withavatar', [BadgeController::class, 'showAllBadgesWithAvatar']);
    Route::get('badges/individuals', [BadgeController::class, 'showAllIndividualBadges']);
    Route::get('badges/globals', [BadgeController::class, 'showAllGlobalBadges']);
    Route::get('badges/{badgeId}', [BadgeController::class, 'show']);
    Route::get('badges/{badgeId}', [BadgeController::class, 'show']);

    // CHALLENGES
    Route::get('challenges', [ChallengeController::class, 'index']);
    Route::get('challenges/{challengeId}', [ChallengeController::class, 'show']);

    // DAILY CHALLENGE STEPS
    Route::get('daily-challenges-steps', [DailyChallengeStepsController::class, 'index']);
    Route::get('daily-challenges-steps/{dailyChallengeId}', [DailyChallengeStepsController::class, 'show']);
    // Route::post('daily-challenges-steps/{dailyChallengeId?}', [DailyChallengeStepsController::class, 'createOrUpdate']);
    Route::delete('daily-challenges-steps/{dailyChallengeId}', [DailyChallengeStepsController::class, 'destroy']);

    // DAILY STEPS
    Route::post('daily-steps', [DailyStepsController::class, 'createOrUpdate']);

    // HEALTH MESSAGES
    Route::get('health-messages', [HealthMessagesController::class, 'index']);
    Route::get('health-messages/random', [HealthMessagesController::class, 'showRandom']);
    Route::get('health-messages/{healthMessageId}', [HealthMessagesController::class, 'show']);

    // USERS
    Route::get('users/badges', [UsersController::class, 'showUserBadges']);
    Route::post('users/badges', [UsersController::class, 'addBadge']);

    Route::get('users/daily-steps/all', [UsersController::class, 'showAllUserSteps']);
    Route::get('users/daily-steps/last', [UsersController::class, 'lastUserSteps']);
    Route::get('users/daily-steps/atdate', [UsersController::class, 'showUserStepsAtDate']);

    Route::get('users', [UsersController::class, 'index']);
    Route::get('users/{userId}', [UsersController::class, 'show']);

    // Admin specific routes
    Route::middleware('admin')->group(function () {
        // AVATARS
        Route::post('avatars/{avatarId?}', [AvatarController::class, 'createOrUpdate']);
        Route::delete('avatars/{avatarId}', [AvatarController::class, 'destroy']);

        // BADGES
        Route::post('badges/{badgeId?}', [BadgeController::class, 'createOrUpdate']);
        Route::delete('badges/{badgeId}', [BadgeController::class, 'destroy']);
        
        // CHALLENGES
        Route::post('challenges/{challengeId?}', [ChallengeController::class, 'createOrUpdate']);
        Route::delete('challenges/{challengeId}', [ChallengeController::class, 'destroy']);

        // DAILY STEPS
        Route::get('daily-steps', [DailyStepsController::class, 'index']);
        Route::delete('daily-steps/{dailyStepId}', [DailyStepsController::class, 'destroy']);

        // HEALTH MESSAGES
        Route::post('health-messages/{healthMessageId?}', [HealthMessagesController::class, 'createOrUpdate']);
        Route::delete('health-messages/{healthMessageId}', [HealthMessagesController::class, 'destroy']);

        // USERS
        Route::delete('users/badges/{userId}/{badgeId}', [UsersController::class, 'removeBadge']);
        Route::post('users/{userId?}', [UsersController::class, 'createOrUpdate']);
        Route::delete('users/{userId}', [UsersController::class, 'destroy']);
    
        // USERS IMPORT/EXPORT
        Route::post('/import', [UsersController::class, 'import']);
        Route::post('/export/{challengeId}', [UsersController::class, 'export']);
    });
});
