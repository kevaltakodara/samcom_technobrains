<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Role;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = Employee::where('status','!=','T')->simplePaginate(10);
        return view('employee.index', compact('data'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('employee.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:employees',
            'phone' => 'required',
        ]);
        Employee::create($request->all());
     
        return redirect()->route('emp.index')
                        ->with('success','Employee created successfully.');
    }

    public function show($id)
    {
        //
    }

    public function edit(Employee $employee)
    {
        $roles = Role::all();
        return view('employee.edit', compact('employee', 'roles'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:employees,email,'.$employee->id,
            'phone' => 'required',
        ]);
    
        $employee->update($request->all());
     
        return redirect()->route('emp.index')
                        ->with('success','Employee updated successfully.');   
                    }
                    
    public function destroy(Employee $employee)
    {
            $employee->update(['status'=>'T']);
            return redirect()->route('emp.index')
                ->with('success','Employee deleted successfully.');   
    }
}
