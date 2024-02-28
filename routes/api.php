<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\BadgeController;

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

// Route::resource('/badges', [BadgeController::class, 'index']);
Route::resource('badges', BadgeController::class);

// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);

// Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


