<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'blank']);
Route::get('login', [FrontendController::class, 'login']);
Route::get('register', [FrontendController::class, 'register']);
Route::get('forgotpass', [FrontendController::class, 'forgotpass']);


Route::group([
    'prefix' => 'backend',
],function(){
    Route::get('/', [BackendController::class, 'dashboard']);
    Route::get('dashboard', [BackendController::class, 'dashboard']);
    Route::get('logout', [BackendController::class, 'logout']);

    //Routing Resource
    Route::resource('products', ProductController::class);

});