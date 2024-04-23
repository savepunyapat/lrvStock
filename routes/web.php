<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;

Route::get('/', [BackendController::class, 'blank']);
Route::get('login', [BackendController::class, 'login']);
Route::get('register', [BackendController::class, 'register']);
Route::get('forgotpass', [BackendController::class, 'forgotpass']);

//Routing Resource
Route::resource('products', ProductController::class);