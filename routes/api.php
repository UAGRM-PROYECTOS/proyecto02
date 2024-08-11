<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\PagoController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/logout', [AuthApiController::class, 'logout'])->middleware('auth:sanctum');


Route::get('/consultarlo', [PagoController::class, 'AccessPagoFacilv2'])->middleware('auth:sanctum');

//callback
Route::post('/callback', [PagoController::class, 'CallBack']);
