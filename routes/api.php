<?php

use App\Http\Controllers\EventsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/events', [EventsController::class, 'showAll']);

Route::get('/events/{id}', [EventsController::class, 'show']);

Route::post('/events', [EventsController::class, 'create']);

Route::delete('/events/{id}', [EventsController::class, 'destroy']);

