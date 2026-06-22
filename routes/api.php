<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'App\Http\Controllers\api\v1'], function () {
    //Workflow
    // Route::apiResource('workflows', 'WorkflowApiController')->names('workflows');
    // Workflows
    Route::get('workflows', 'WorkflowApiController@index');
    Route::post('workflows/refresh', 'WorkflowApiController@refresh');
    Route::get('workflows/{id}', 'WorkflowApiController@show');
    Route::post('workflows/{id}/refresh', 'WorkflowApiController@refreshOne');
    
    Route::apiResource('status-management-settings', 'StatusManagementSettingsApiController')->names('status-management-settings');
    Route::apiResource('labor-cost-change-log', 'LaborCostChangeLogApiController')->names('labor-cost-change-log');
    Route::apiResource('labor-costs', 'LaborCostApiController')->names('labor-costs');
    Route::apiResource('building-structures', 'BuildingStructureApiController')->names('building-structures');
    Route::apiResource('projects', 'ProjectApiController')->names('projects');
    Route::post('users/sync-roles', 'RoleSyncApiController@syncUserRoles')->name('users.sync-roles');
});
