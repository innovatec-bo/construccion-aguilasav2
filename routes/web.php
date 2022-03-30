<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\admin', 'middleware' => ['auth']], function () {
    //Home
    Route::get('home','HomeController@index')->name('home.index');

    //Users
    Route::resource('users','UserController')->names('users');
});



Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
