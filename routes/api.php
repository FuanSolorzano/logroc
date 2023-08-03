<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogicContoller;
use App\Http\Controllers\Personas;
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

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/auth/provincias', [LogicContoller::class, 'listap']);
    Route::get('/auth/cantones', [LogicContoller::class, 'cantonesp']);
    Route::get('/auth/recintos', [LogicContoller::class, 'recintosp']);
    Route::put('/auth/recintos/{id}', [LogicContoller::class, 'updateRecinto']);
    Route::delete('/auth/eliminar/{id}',[LogicContoller::class, 'Eliminar']);
});

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

