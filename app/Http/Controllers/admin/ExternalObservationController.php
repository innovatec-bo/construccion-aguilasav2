<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ExternalObservation;
use Illuminate\Http\Request;

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
