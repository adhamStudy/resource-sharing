<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/resource',[HomeController::class,'resource'])->name('resource');
Route::get('/create',[HomeController::class,'create'])->name('create')->middleware(['auth']);
Route::post('/store',[HomeController::class,'store'])->name('store');

Route::get('/show/{resource}',[HomeController::class,'show']);
Route::post('/resources/{resource}/reserve', [HomeController::class, 'reserve'])
    ->name('resources.reserve')
    ->middleware(['auth']);

Route::get('/login',[AuthController::class,'create'])->name('login');
Route::post('/login',[AuthController::class,'store'])->name('login');
Route::post('/logout',[AuthController::class,'destroy'])->name('logout');

Route::resource('/user-account', UserAccountController::class)
   ->only(['create','store']);



   Route::middleware(['auth'])->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
});