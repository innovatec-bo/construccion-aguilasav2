<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('home/magic-login/{encrypted}',[HomeController::class,'magicLogin'])->name('home.magic-login');

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
    Route::get('movimientos/movimientos-agrupados/{project}','MaterialSummaryController@groupedMovementDetails')->name('materials-summary.grouped-movement-details');
    Route::get('movimientos/movimientos-agrupados','MaterialSummaryController@groupedMovements')->name('materials-summary.grouped-movements');
    Route::get('materials-summary/load-initial-list','MaterialSummaryController@loadInitialList')->name('materials-summary.load-initial-list');
    Route::resource('materials-summary','MaterialSummaryController')->names('materials-summary');

    //Building Structures
    Route::get('building-structures/upload-default-materials','BuildingStructureController@uploadDefaultMaterials')->name('building-structures.upload-default-materials');
    Route::resource('building-structures','BuildingStructureController')->names('building-structures');

    //Labor Details
    Route::get('mano-de-obra/conciliacion-interna-formato-cre/{labor_detail}','LaborDetailController@internalConciliationCreFormat')->name('labor-details.internal-conciliation-cre-format');
    Route::get('labor-details/internal-conciliation-builder/{labor_detail}','LaborDetailController@internalConciliationBuilder')->name('labor-details.internal-conciliation-builder');
    Route::get('labor-details/internal-conciliation/{labor_detail}','LaborDetailController@internalConciliation')->name('labor-details.internal-conciliation');
    Route::resource('labor-details','LaborDetailController')->names('labor-details');

    //Materials
    Route::resource('materials', 'MaterialController')->names('materials');

    //Builder debts report
    Route::get('builder-debts-report', 'BuilderDebtReport@index')->name('builder-debts-report.index');

    //Labor costs
    Route::resource('labor-costs', 'LaborCostController')->names('labor-costs');
});

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

Auth::routes(['register' => false]);