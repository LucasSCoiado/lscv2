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
    
    //create
    Route::get('/create', [MainController::class, 'create'])->name('create');
    Route::post('/store', [MainController::class, 'store'])->name('store');

    //edit
    Route::get('/edit/{id}', [MainController::class, 'edit'])->name('edit');
    Route::post('/update', [MainController::class, 'update'])->name('update');

    //Delete
    Route::get('/delete/{id}', [MainController::class, 'delete'])->name('delete');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
