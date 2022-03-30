<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\admin', 'middleware' => ['auth']], function () {
    //Home
    Route::get('home','HomeController@index')->name('home.index');

    //Users
    Route::resource('users','UserController')->names('users');
});

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

Auth::routes(['register' => false]);