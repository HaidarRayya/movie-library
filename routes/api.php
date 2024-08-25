<?php

use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Customer\MovieController as CustomerMovieController;
use App\Http\Controllers\Admin\RatingController as AdminRatingController;
use App\Http\Controllers\Customer\RatingController as CustomerRatingController;
use App\Http\Controllers\Auth\AuthController;
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

Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::post("/logout", [AuthController::class, "logout"]);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::apiResource('movies', AdminMovieController::class);
    Route::apiResource('movies.ratings', AdminRatingController::class)->only(['index', 'show']);
});

Route::prefix('customer')->group(function () {
    Route::apiResource('movies', CustomerMovieController::class)->only(['index', 'show']);
    Route::apiResource('movies.ratings', CustomerRatingController::class);
});
