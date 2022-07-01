<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalObservation;
use App\Models\ExternalObservationType;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ExternalObservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.external-observations.index', ['only' => ['index']]);
        $this->middleware('permission:admin.external-observations.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.external-observations.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.external-observations.show', ['only' => ['show']]); 
        $this->middleware('permission:admin.external-observations.delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.external-observations.index');
    }

    public function messages()
    {
        return [
            'code_pro.exists' => 'El proyecto no existe',
            'fiscal_id_efo.exists' => "El fiscal no existe",
            'observation_efo.required' => 'La observacion es requerida',
            'entry_date_efo.date_format' => 'El formato de fecha es incorreccto' 
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $fiscals = User::role('Fiscal de CRE')->get()->pluck('full_name','id_usr');
        $externalObservationTypes = ExternalObservationType::all()->pluck('name','id');
        return view('admin.external-observations.create', compact('fiscals','externalObservationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code_pro' => ['required', 'exists:wfl_projects,code_pro'],
            'fiscal_id_efo' => ['required', 'exists:sec_users,id_usr'],
            'external_observation_type_id' => ['required', 'exists:external_observation_types,id'],
            'observation_efo' => ['required'],
            'entry_date_efo' => ['required', 'date_format:d/m/Y H:i:s']
        ],$this->messages());
        $request->entry_date_efo = Carbon::createFromFormat('d/m/Y H:i:s', $request->entry_date_efo)->format('Y-m-d H:i:s');
        $project = Project::where('code_pro', $request->code_pro)->first();
        $data = [
            'project_id_efo' => $project->id_pro,
            'fiscal_id_efo' => $request->fiscal_id_efo,
            'external_observation_type_id' => $request->external_observation_type_id,
            'observation_efo' => $request->observation_efo,
            'entry_date_efo' => $request->entry_date_efo,
            'status_id_efo' => $project->status_pro
        ];
        ExternalObservation::create($data);
        Session::flash('Observacion externa creada exitosamente.');
        return redirect()->route('admin.external-observations.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExternalObservation $externalObservation)
    {
        return view('admin.external-observations.show', compact('externalObservation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function markAsFixed(ExternalObservation $externalObservation)
    {
        return view('admin.external-observations.mark-as-fixed', compact('externalObservation'));
    }

    public function markAsFixedUpdate(Request $request, ExternalObservation $externalObservation)
    {
        $this->validate($request, [
            'fix_detail_efo' => 'required',
            'fixed_date_efo' => 'required|date_format:d/m/Y H:i:s'
        ]);

        $externalObservation->fixed_by_efo = Auth::user()->id_usr;
        $externalObservation->fix_detail_efo = $request->fix_detail_efo;
        $externalObservation->fixed_date_efo = Carbon::createFromFormat('d/m/Y H:i:s', $request->fixed_date_efo)->format('Y-m-d H:i:s');
        $externalObservation->save();
        Session::flash('successMessage', 'Observacion marcada como resuelta.');
        return redirect()->route('admin.external-observations.index');
    }
}
