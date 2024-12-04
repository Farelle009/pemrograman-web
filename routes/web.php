<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/belajar-route', function () {
    return 'Hello World';
});

Route::resource('contacts', ContactController::class);
