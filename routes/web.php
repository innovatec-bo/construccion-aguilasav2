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
    Route::get('materials-summary/load-initial-list','MaterialSummaryController@loadInitialList')->name('materials-summary.load-initial-list');
    Route::resource('materials-summary','MaterialSummaryController')->names('materials-summary');

    //Building Structures
    Route::post('building-structures/store-default-materials','BuildingStructureController@storeDefaultMaterials')->name('building-structures.store-default-materials');
    Route::get('building-structures/upload-default-materials','BuildingStructureController@uploadDefaultMaterials')->name('building-structures.upload-default-materials');
    Route::resource('building-structures','BuildingStructureController')->names('building-structures');

    //Labor Details
    Route::get('labor-details/internal-conciliation-builder/{labor_detail}','LaborDetailController@internalConciliationBuilder')->name('labor-details.internal-conciliation-builder');
    Route::get('labor-details/internal-conciliation/{labor_detail}','LaborDetailController@internalConciliation')->name('labor-details.internal-conciliation');
    Route::resource('labor-details','LaborDetailController')->names('labor-details');

    //Materials
    Route::resource('materials', 'MaterialController')->names('materials');
});

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

Auth::routes(['register' => false]);