<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\UserLogged;
use App\Http\Middleware\UserNotLogged;

Route::middleware('guest')->group(function(): void{
    Route::get('/confirm-account/{token}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
    Route::get('/new_user_confirmation/{token}', [UserController::class, 'new_user_confirm'])->name('new_user_confirmation');
    Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAcountSubmit'])->name('confirm-account-submit');
    
    // forgot pass
    Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/forgot-password', [AuthController::class, 'sendRessetPasswordLink'])->name('send_restart_password_link');
    
    // reset pass
    Route::get('/reset-password/{token}', [AuthController::class, 'reset_password'])->name('reset_password');
    Route::post('/reset-password', [AuthController::class, 'reset_password_update'])->name('reset_password_update');
});

Route::middleware([UserNotLogged::class])->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
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
    Route::get('/destroy/{id}', [MainController::class, 'destroy'])->name('destroy');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
});

Route::group(['prefix'=>'user'], function(){
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
});