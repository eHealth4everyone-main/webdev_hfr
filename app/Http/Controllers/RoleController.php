<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller
{

    public function index()
    {
        $roles=Role::get();
        $permissions=Permission::get();

        return view("/roles/index",compact("roles","permissions"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|string|max:50',
            'perm' => 'required',
        ]);

        
        $role = Role::create(['name' => $request->role]);
        $role->givePermissionTo($request->perm);

        session()->flash("alert-success", "Role created successfully!");
        return back();
    }

  
    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request)
    {
        $request->validate([
            'role1' => 'required|string|max:50',
            'perm1' => 'required',
        ]);

        $role = Role::findOrfail($request->RoleID);
        $role->name = $request->role1;
        $role->save();

        $role->syncPermissions($request->perm1);

        session()->flash("alert-success", "Role updated successfully!");
        return back();
    }
    
    public function destroy($id)
    {
        //
    }
}
