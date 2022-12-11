<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Employee;

class RoleController extends Controller
{
    public function index()
    {
        $data = Role::with('employees')->simplePaginate(10);
        return view('roles.index', compact('data'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
    
        Role::create($request->all());
     
        return redirect()->route('role.index')
                        ->with('success','Role created successfully.');
    }

    public function show()
    {
    }
    
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
        
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
        ]);
    
        $role->update($request->all());
     
        return redirect()->route('role.index')
                        ->with('success','Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $employee = Employee::where('role_id', $role->id)->whereIn('status', ['Y', 'N'])->first();

        if(isset($employee) && count(collect($employee)) > 0){
            return redirect()->route('role.index')
                        ->with('error','Role has employees, can not be deleted.');
        }

        $role->delete();

        return redirect()->route('role.index')
                        ->with('success','Role deleted successfully.');
    }
}
