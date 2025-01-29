<?php

use App\Http\Controllers\halo\HaloController;
use App\Http\Controllers\todo\TodoController;
use App\Http\Controllers\User\ForgotController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/coba', function () {
    return view('coba.cobacoba');
});

Route::get('/halo', [HaloController::class, 'index']);

// TODOLIST
Route::middleware('auth')->group(function(){
    // todo
    Route::get('/todo', [TodoController::class, 'index'])->name('todo');
    Route::post('/todo', [TodoController::class, 'store'])->name('todo.post');
    Route::put('/todo/{id}', [TodoController::class, 'update'])->name('todo.update');
    Route::delete('/todo/{id}', [TodoController::class, 'destroy'])->name('todo.delete');

    // User
    Route::get('/user/update', [UserController::class, 'updateData'])->name('user.update');
    Route::post('/user/update', [UserController::class, 'doUpdateData'])->name('user.update.post');
});


Route::middleware('guest')->group(function(){
    // REGISTER
    Route::get('/user/register', [UserController::class, 'register'])->name('register');
    Route::post('/user/register', [UserController::class, 'doRegister'])->name('register.post');
    Route::get('/user/verify/{token}', [UserController::class, 'verifAcc'])->name('user.verify');
    
    
    // LOGIN
    Route::get('/user/login', [UserController::class, 'login'])->name('login');
    Route::post('/user/login', [UserController::class, 'doLogin'])->name('login.post');

    // FORGOR
    Route::get('/user/forgor', [ForgotController::class, 'iforgor'])->name('forgor');
    Route::post('/user/forgor', [ForgotController::class, 'sendReset'])->name('forgor.post');
    Route::get('user/reset/{token}', [ForgotController::class, 'resetPassword'])->name('forgor.reset');
    Route::post('user/reset', [ForgotController::class, 'doReset'])->name('forgor.reset.post');
});

Route::get('/user/logout', [UserController::class, 'logout'])->name('logout');