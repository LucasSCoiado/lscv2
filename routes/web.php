<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MainController;
use App\Http\Middleware\UserLogged;
use App\Http\Middleware\UserNotLogged;

Route::middleware([UserNotLogged::class])->group(function(){
    Route::get('/login', [AuthController::class, 'login']);
    Route::post('/loginSubmit', [AuthController::class, 'loginSubmit'])->name('loginSubmit');
});

Route::middleware([UserLogged::class])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('home');
    Route::get('/newCrise', [MainController::class, 'newCrise'])->name('new');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
