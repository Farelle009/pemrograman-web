<?php

use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/contacts', ContactController::class);

Route::get('/contacts/create', [ContactController::class, 'create']);
Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit']);