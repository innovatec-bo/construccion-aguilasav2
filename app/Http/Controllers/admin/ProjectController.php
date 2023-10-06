<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Imports\ManpowerImport;
use App\Models\LaborDetail;
use App\Models\NextStatus;
use App\Models\Project;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.projects.index', ['only' => ['index']]);
        $this->middleware('permission:admin.projects.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.projects.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.projects.show', ['only' => ['show']]); 
        $this->middleware('permission:admin.projects.delete', ['only' => ['destroy']]); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }

    public function rectifyManpower()
    {
        return view('admin.projects.rectify-manpower');   
    }

    public function updateManpower(Request $request)
    {
        $project = Project::where('code_pro', $request->get('project-code'))->first();
        $import = new ManpowerImport();
        $data = Excel::toArray($import, $request->file('file'));
        LaborDetail::updatePrices($project, $data);
        // $externalBalanceId = ExternalBalance::saveData($data);
        
        // $response['externalBalanceId'] = $externalBalanceId;
        // return response()->json(
        //     $response
        // );
        // dd($project);
    }

    public function statusManagement(Project $project)
    {
        $nextStatusList = NextStatus::where('parent_status_id', $project->status_pro)->get();
        return view('admin.projects.status-management', compact('project', 'nextStatusList'));
    }
}
