<?php

namespace App\Http\Controllers\admin;

use App\Exports\LaborCostLogExport;
use App\Http\Controllers\Controller;
use App\Settings\StatusManagementSettings;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home.index');
    }

    public function dashboard()
    {
        return view('admin.home.dashboard');
    }

    public function testExport() 
    {
        $contents = Excel::raw(new LaborCostLogExport, 'Xlsx');
        dd($contents);
    }
}
