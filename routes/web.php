<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('login', function(){
    return redirect("/");
})->name('login');
Route::post('authenticate',[LoginController::class,'authenticate'])->name('authenticate');
Route::get('home/magic-login/{encrypted}',[HomeController::class,'magicLogin'])->name('home.magic-login');

Route::group(['prefix' => '', 'as' => '', 'namespace' => 'App\Http\Controllers', 'middleware' => []], function () {
    
    Route::get('/','HomeController@index')->name('home.index');
});

Route::group(['prefix' => 'administracion', 'as' => 'admin.', 'namespace' => 'App\Http\Controllers\admin', 'middleware' => ['auth']], function () {
    //Home
    Route::get('test-export','HomeController@testExport')->name('home.export');
    Route::get('inicio','HomeController@index')->name('home.index');
    Route::get('dashboard','HomeController@dashboard')->name('home.dashboard');

    //Users
    Route::get('usuarios/exportar/{users}','UserController@export')->name('users.export');
    Route::resource('usuarios','UserController')->parameters(['usuarios' => 'user'])->names('users');

    //Permissions
    Route::resource('permisos','PermissionController')->parameters(['permisos' => 'permission'])->names('permissions');

    //Roles
    Route::resource('roles','RoleController')->names('roles');

    //Projects
    Route::get('proyectos/administracion-de-estados/{project}','ProjectController@statusManagement')->name('projects.status-management');
    Route::post('proyectos/actualizar-mano-de-obra','ProjectController@updateManpower')->name('projects.update-manpower');
    Route::get('proyectos/rectificar-mano-de-obra','ProjectController@rectifyManpower')->name('projects.rectify-manpower');
    Route::resource('proyectos','ProjectController')->names('projects');

    //Materials Summary
    Route::get('movimientos/movimientos-duplicados', 'MaterialSummaryController@duplicateOutputs')->name('materials-summary.duplicate-outputs');
    Route::get('movimientos/movimientos-agrupados/{project}','MaterialSummaryController@groupedMovementDetails')->name('materials-summary.grouped-movement-details');
    Route::get('movimientos/movimientos-agrupados','MaterialSummaryController@groupedMovements')->name('materials-summary.grouped-movements');
    Route::get('movimientos/cargar-lista-inicial','MaterialSummaryController@loadInitialList')->name('materials-summary.load-initial-list');
    Route::resource('movimientos','MaterialSummaryController')->parameters(['movimientos' => 'materials_summary'])->names('materials-summary');

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
    Route::get('materiales/depurar-pendientes-en-cre', 'MaterialController@debugPendingInCRE')->name('materials.debug-pending-in-cre');
    Route::get('materiales/resumen', 'MaterialController@materialSummary')->name('materials.material-summary');
    Route::resource('materiales', 'MaterialController')->names('materials');

    //Builder debts report
    Route::get('constructores-y-deudas', 'BuilderDebtReport@index')->name('builder-debts-report.index');

    //Labor costs
    Route::resource('labor-costs', 'LaborCostController')->names('labor-costs');

    //Labor cost log
    Route::resource('labor-cost-log', 'LaborCostLogController')->names('labor-cost-log');

    //Project materials
    Route::resource('project-materials','ProjectMaterialController')->names('project-materials');

    //External observations
    Route::post('observaciones-externas/marcar-como-resuelto-actualizar/{external_observation}', 'ExternalObservationController@markAsFixedUpdate')->name('external-observations.mark-as-fixed-update');
    Route::get('observaciones-externas/marcar-como-resuelto/{external_observation}', 'ExternalObservationController@markAsFixed')->name('external-observations.mark-as-fixed');
    Route::resource('observaciones-externas', 'ExternalObservationController')->parameters(['observaciones-externas' => 'external_observation'])->names('external-observations');

    //External balance material
    Route::resource('balance-externo-de-materiales', 'ExternalBalanceMaterialController')->parameters(['balance-externo-de-materiales' => 'external_balance_material'])->names('external-balance-material');

    //Contracts
    Route::resource('contratos','ContractController')->parameters(['contratos' => 'contract'])->names('contracts');

    //Pruning
    Route::resource('podas','TreePruningController')->parameters(['podas' => 'tree_pruning'])->names('tree-prunings');

    //External Balance
    Route::resource('balance-externo','ExternalBalanceController')->parameters(['balance-externo' => 'external-balance'])->names('external-balance');

    //Settings - Status management
    // Route::resource('status-management-settings','StatusManagementSettingsController')->names('status-management-settings');
    Route::get('status-management-settings/edit','StatusManagementSettingsController@edit')->name('status-management-settings.edit');
    Route::post('status-management-settings/update','StatusManagementSettingsController@update')->name('status-management-settings.update');

    //Project Status
    Route::resource('project-status', 'ProjectStatusController')->names('project-status');
    

    // Route::post('/print', function(Request $request) { 
    //     $body = $request->body;
    //     return view('print', compact('body')); 
    // })->name('print');
});

// Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm');

// Auth::routes(['register' => false]);

/*
 SELECT
	code_pro,
	mat_materials_summary.project_id_msu,
	id_mat,
    description_mat,
    mat_materials_summary.id_msu,
    mat_materials_summary_types.name_mqt,
    mat_materials_summary_types.keyword_mqt
FROM
    mat_materials
LEFT JOIN mat_projects_materials on mat_projects_materials.material_id_prm = id_mat
LEFT JOIN mat_materials_summary on materials_summary_id_prm = mat_materials_summary.id_msu
LEFT JOIN wfl_projects on id_pro = project_id_msu
LEFT JOIN mat_materials_summary_types on id_mqt = summary_type_id_msu
where 
	project_id_msu = 2495
    and mat_projects_materials.deleted_prm != 1
    and mat_projects_materials.deleted_at is null
    and mat_materials_summary.deleted_msu != 1
    and mat_materials_summary.deleted_at is null
    and wfl_projects.deleted_pro != 1
    and 
    and mat_materials_summary_types.deleted_mqt != 1
    and mat_materials_summary_types.deleted_at is null
order by id_msu, keyword_mqt, id_mat;
 */