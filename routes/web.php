<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/', [App\Http\Controllers\UsesrController::class, 'login'])->name('users.login');
Route::get('/dashboard', [App\Http\Controllers\UsersController::class, 'dashboard'])->name('users.dashboard');