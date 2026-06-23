<?php

namespace App\Http\Controllers\admin;

use App\CustomLibraries\WorkflowPaginationHandler;
use App\Exports\LaborCostLogExport;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Workflow;
use App\Settings\StatusManagementSettings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index()
    {
        $t0 = microtime(true);
        $handler = new WorkflowPaginationHandler(1, 0);
        $handler->setAdditionalParameters(['id-list' => 5543]);
        $result = $handler->getAll();
        $t1 = microtime(true);
        \Log::info("Serebo2 handler: " . round($t1 - $t0, 3) . "s para " . count($result) . " filas");
        return view('admin.home.index');
    }

    public function dashboard()
    {
        return view('admin.home.dashboard');
    }

    public function testExport() 
    {
        $project = Project::find(3187);
        // Excel::download(new LaborCostLogExport($project), 'test.xlsx');
    }
}
