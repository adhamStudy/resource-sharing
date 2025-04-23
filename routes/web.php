<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/resource',[HomeController::class,'resource'])->name('resource');
Route::get('/create',[HomeController::class,'create'])->name('create')->middleware(['auth']);
Route::post('/store',[HomeController::class,'store'])->name('store');

Route::get('/login',[AuthController::class,'create'])->name('login');
Route::post('/login',[AuthController::class,'store'])->name('login');
Route::post('/logout',[AuthController::class,'destroy'])->name('logout');