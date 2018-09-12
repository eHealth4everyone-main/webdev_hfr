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
        // dd($request);

        $request->validate([
            'role' => 'required|string|max:50',
            'description' => 'required|string|max:100',
            'perm' => 'required',
        ]);

        
        $role = Role::create([
            'name' => $request->role,
            'description' => $request->description
            ]);
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
            'description1' => 'required|string|max:100',
            'perm1' => 'required',
        ]);

        $role = Role::findOrfail($request->RoleID);
        $role->name = $request->role1;
        $role->description = $request->description1;
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
