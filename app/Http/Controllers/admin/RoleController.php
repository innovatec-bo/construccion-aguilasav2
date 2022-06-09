<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:admin.roles.index', ['only' => ['index']]);
        $this->middleware('permission:admin.roles.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:admin.roles.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:admin.roles.show', ['only' => ['show']]); 
        $this->middleware('permission:admin.roles.delete', ['only' => ['destroy']]); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::orderBy('detail')->get()->pluck('detail','id');
        return view('admin.roles.create', compact('permissions'));
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
            'name' => ['required','unique:roles,name'],
            'permissions_checked' => ['required']
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);
        $permissions = Permission::whereIn('id', $request->permissions_checked)->get();
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')->with('successMessage','Rol agregado exitosamente.');
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
    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('detail')->get()->pluck('detail','id');
        $permissionInRole = $role->permissions->pluck('id');
        return view('admin.roles.edit', compact('role','permissions', 'permissionInRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => ['required','unique:roles,name,'.$role->id]
        ]);
        $role->name = $request->name;
        $role->save();

        $permissions = Permission::whereIn('id', $request->permissions_checked)->get();
        $role->syncPermissions($permissions);

        return redirect()->route('admin.roles.index')->with('successMessage','Rol editado exitosamente.');
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
