<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('home/magic-login/{encrypted}',[HomeController::class,'magicLogin'])->name('home.magic-login');

Route::group(['prefix' => 'administracion', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\admin', 'middleware' => ['auth']], function () {
    //Home
    Route::get('inicio','HomeController@index')->name('home.index');

    //Users
    Route::get('usuarios/exportar/{users}','UserController@export')->name('users.export');
    Route::resource('usuarios','UserController')->parameters(['usuarios' => 'user'])->names('users');

    //Permissions
    Route::resource('permisos','PermissionController')->parameters(['permisos' => 'permission'])->names('permissions');

    //Roles
    Route::resource('roles','RoleController')->names('roles');

    //Projects
    Route::post('proyectos/actualizar-mano-de-obra/{project}','ProjectController@updateManpower')->name('projects.update-manpower');
    Route::get('proyectos/rectificar-mano-de-obra','ProjectController@rectifyManpower')->name('projects.rectify-manpower');
    Route::resource('proyectos','ProjectController')->names('projects');

    //Materials Summary
    Route::get('movimientos/movimientos-duplicados', 'MaterialSummaryController@duplicateOutputs')->name('materials-summary.duplicate-outputs');
    Route::get('movimientos/movimientos-agrupados/{project}','MaterialSummaryController@groupedMovementDetails')->name('materials-summary.grouped-movement-details');
    Route::get('movimientos/movimientos-agrupados','MaterialSummaryController@groupedMovements')->name('materials-summary.grouped-movements');
    Route::get('resumen-de-materiales/cargar-lista-inicial','MaterialSummaryController@loadInitialList')->name('materials-summary.load-initial-list');
    Route::resource('resumen-de-materiales','MaterialSummaryController')->parameters(['resumen-de-materiales' => 'materials_summary'])->names('materials-summary');

    //Building Structures
    Route::get('estructuras-de-construccion/upload-default-materials','BuildingStructureController@uploadDefaultMaterials')->name('building-structures.upload-default-materials');
    Route::resource('estructuras-de-construccion','BuildingStructureController')->parameters(['estructuras-de-construccion' => 'building_structure'])->names('building-structures');

    //Labor Details
    Route::get('manos-de-obra/exportar-conciliacion-interna/{laborDetail}','LaborDetailController@exportInternalConciliation')->name('labor-details.export-internal-conciliation');
    Route::get('manos-de-obra/exportar-conciliacion-interna-formato-cre/{laborDetail}','LaborDetailController@exportInternalConciliationCreFormat')->name('labor-details.export-internal-conciliation-cre-format');
    Route::get('manos-de-obra/exportar/{laborDetail}','LaborDetailController@export')->name('labor-details.export');
    Route::get('manos-de-obra/conciliacion-interna-formato-cre/{labor_detail}','LaborDetailController@internalConciliationCreFormat')->name('labor-details.internal-conciliation-cre-format');
    Route::get('manos-de-obra/internal-conciliation-builder/{labor_detail}','LaborDetailController@internalConciliationBuilder')->name('labor-details.internal-conciliation-builder');
    Route::get('manos-de-obra/internal-conciliation/{labor_detail}','LaborDetailController@internalConciliation')->name('labor-details.internal-conciliation');
    Route::resource('manos-de-obra','LaborDetailController')->parameters(['manos-de-obra' => 'labor_detail'])->names('labor-details');

    //Materials
    Route::resource('materiales', 'MaterialController')->names('materials');

    //Builder debts report
    Route::get('constructores-y-deudas', 'BuilderDebtReport@index')->name('builder-debts-report.index');

    //Labor costs
    Route::resource('labor-costs', 'LaborCostController')->names('labor-costs');

    //Project materials
    Route::resource('project-materials','ProjectMaterialController')->names('project-materials');

    //External observations
    Route::post('observaciones-externas/marcar-como-resuelto-actualizar/{external_observation}', 'ExternalObservationController@markAsFixedUpdate')->name('external-observations.mark-as-fixed-update');
    Route::get('observaciones-externas/marcar-como-resuelto/{external_observation}', 'ExternalObservationController@markAsFixed')->name('external-observations.mark-as-fixed');
    Route::resource('observaciones-externas', 'ExternalObservationController')->parameters(['observaciones-externas' => 'external_observation'])->names('external-observations');
});

Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

Auth::routes(['register' => false]);