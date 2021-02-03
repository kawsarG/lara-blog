<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['as'=>'admin.','prefix'=>'admin','namespace'=>'admin','middleware'=>['auth','admin']],function(){
    Route::get('dashboard',[\App\Http\Controllers\Admin\DashboardController::class,'index'])->name('dashboard');
    Route::resource('tag',TagController::class);
});

Route::group(['as'=>'author.','prefix'=>'author','namespace'=>'author','middleware'=>['auth','author']],function(){
    Route::get('dashboard',[\App\Http\Controllers\Author\DashboardController::class,'index'])->name('dashboard');
});
