<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/register', [\App\Http\Controllers\Api\V1\AuthController::class, 'register'])->name('api.v1.register');
Route::post('v1/login', [\App\Http\Controllers\Api\V1\AuthController::class, 'login'])->name('api.v1.login');

Route::middleware('auth:sanctum')->get('v1/todos', [\App\Http\Controllers\Api\V1\TodoController::class, 'index'])->name('api.v1.todos.index');
Route::middleware('auth:sanctum')->post('v1/todos', [\App\Http\Controllers\Api\V1\TodoController::class, 'store'])->name('api.v1.todos.store');
Route::middleware('auth:sanctum')->get('v1/todos/{todo}', [\App\Http\Controllers\Api\V1\TodoController::class, 'show'])->name('api.v1.todos.show');
Route::middleware('auth:sanctum')->put('v1/todos/{todo}', [\App\Http\Controllers\Api\V1\TodoController::class, 'update'])->name('api.v1.todos.update');
