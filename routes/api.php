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

// User register
Route::post('/register', [RegisterController::class, 'register']);

// User login
Route::post('/login', [LoginController::class, 'login']);

// User logout (requires authentication)
Route::middleware('auth:api')->post('/logout', [LoginController::class, 'logout']);

// Protected routes
Route::middleware('auth:api')->group(function () {

	// Add a record
	Route::post('/transactions', [TransactionController::class, 'store']);

	// Get a list of records
	Route::get('/transactions', [TransactionController::class, 'index']);

	// Delete a record
	Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

	// Get a specific record
	Route::get('/transactions/{id}', [TransactionController::class, 'show']);
});






