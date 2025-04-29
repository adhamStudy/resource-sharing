<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;


Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/resource',[HomeController::class,'resource'])->name('resource');
Route::get('/create',[HomeController::class,'create'])->name('create')->middleware(['auth']);
Route::post('/store',[HomeController::class,'store'])->name('store');

Route::get('/show/{resource}',[HomeController::class,'show']);
// Route::get('/edit/{resource}',[HomeController::class,'edit'])->name('edit')->middleware(['auth']);

Route::get('/login',[AuthController::class,'create'])->name('login');
Route::post('/login',[AuthController::class,'store'])->name('login');
Route::post('/logout',[AuthController::class,'destroy'])->name('logout');

Route::resource('/user-account', UserAccountController::class)
   ->only(['create','store']);