<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.project-status.index', ['only' => ['index']]);
        $this->middleware('permission:admin.project-status.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.project-status.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.project-status.show', ['only' => ['show']]); 
        $this->middleware('permission:admin.project-status.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.project-status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
