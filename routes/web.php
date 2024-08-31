<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Index/Index');
});

Route::resource('todos', TodoController::class);
