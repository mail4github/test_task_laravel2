<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

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

/**
 * Register a new user.
 */
Route::post('/register', [RegisterController::class, 'register']);

/**
 * Authenticate a user and generate an access token.
 */
Route::post('/login', [LoginController::class, 'login']);

/**
 * Logout a user (requires authentication).
 */
Route::middleware('auth:api')->post('/logout', [LoginController::class, 'logout']);

/**
 * Protected routes that require authentication.
 */
Route::middleware('auth:api')->group(function () {

    /**
     * Add a new transaction record.
     */
    Route::post('/transactions', [TransactionController::class, 'store']);

    /**
     * Get a list of transaction records with optional filters.
     */
    Route::get('/transactions', [TransactionController::class, 'index']);

    /**
     * Delete a transaction record by ID.
     */
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

    /**
     * Get a specific transaction record by ID.
     */
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
});
