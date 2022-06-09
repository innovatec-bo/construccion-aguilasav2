<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.permissions.index', ['only' => ['index']]);
        $this->middleware('permission:admin.permissions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.permissions.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.permissions.show', ['only' => ['show']]); 
        $this->middleware('permission:admin.permissions.delete', ['only' => ['destroy']]); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.permissions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create');
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
            'name' => 'required|unique:permissions,name',
            'detail' => 'required|max:100'
        ]);

        Permission::create([
            'name' => $request->name,
            'detail' => $request->detail,
            'guard_name' => 'web'
        ]);
        return redirect()->route('admin.permissions.index')->with('successMessage','Permiso creado exitosamente');
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
    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $this->validate($request, [
            'name' => ['required','unique:permissions,name,'.$permission->id],
            'detail' => ['required','max:100']
        ]);

        $permission->name = $request->name;
        $permission->detail = $request->detail;
        $permission->save();
        return redirect()->route('admin.permissions.index')->with('successMessage','Permiso actualizado exitosamente');
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
}
