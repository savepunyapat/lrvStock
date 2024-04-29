<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;

Route::get('/', [FrontendController::class, 'blank']);
Route::get('login', [FrontendController::class, 'login']);
Route::get('register', [FrontendController::class, 'register']);
Route::get('forgotpass', [FrontendController::class, 'forgotpass'])->middleware('auth');
Route::get('nopermission', [BackendController::class],'nopermission');


Route::group([
    'prefix' => 'backend',
    'middleware' => 'admin'
],function(){
    Route::get('/', [BackendController::class, 'dashboard']);
    Route::get('dashboard', [BackendController::class, 'dashboard']);
    Route::get('logout', [BackendController::class, 'logout']);

    //Routing Resource
    Route::resource('products', ProductController::class);

});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
