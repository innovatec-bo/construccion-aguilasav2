<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Settings\StatusManagementSettings;
use Illuminate\Http\Request;

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
}
