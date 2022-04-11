<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\admin', 'middleware' => ['auth']], function () {
    //Home
    Route::get('home','HomeController@index')->name('home.index');

    //Users
    Route::resource('users','UserController')->names('users');

    //Permissions
    Route::resource('permissions','PermissionController')->names('permissions');

    //Roles
    Route::resource('roles','RoleController')->names('roles');

    //Projects
    Route::post('projects/update-manpower/{project}','ProjectController@updateManpower')->name('projects.update-manpower');
    Route::get('projects/rectify-manpower','ProjectController@rectifyManpower')->name('projects.rectify-manpower');
    Route::resource('projects','ProjectController')->names('projects');

    //Materials Summary
    Route::resource('materials-summary','MaterialSummaryController')->names('materials-summary');
});

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

Auth::routes(['register' => false]);