<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectBudget;
use App\Models\TreePruning;
use Illuminate\Http\Request;

class TreePruningController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.tree-prunings.index', ['only' => ['index']]);
        $this->middleware('permission:admin.tree-prunings.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.tree-prunings.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.tree-prunings.show', ['only' => ['show']]); 
        $this->middleware('permission:admin.tree-prunings.delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.tree-prunings.index');
    }

    public function form(ProjectBudget $projectBudget)
    {
        return view('admin.tree-prunings.form', compact('projectBudget'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {

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
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TreePruning $treePruning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TreePruning $treePruning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TreePruning $treePruning)
    {
        //
    }
}
