<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;

class DepartmentController extends Controller
{
   
    public function index()
    {
        return Department::latest()->paginate(10);
    }

   
    public function store(Request $request)
    {
        //validate inputs

        $this->validate($request,[
            'department_code' => 'required|unique:departments|max:6',
            'department_name' => 'required'
        ]);

        return Department::create([
            'department_code' => $request['department_code'],
            'department_name' => $request['department_name'],
        ]);

    }

    
    public function show($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $this->validate($request,[
            'department_code' => 'required|max:6',
            'department_name' => 'required'
        ]);

        $department->update($request->all());

    }

    
    public function destroy($id)
    {
        $department = Department::findOrFail($id);

        $department->delete();
        return ['message' => 'department delete'];
    }

     //search subject table
    public function search(Request $request)
    {
        if( $search = $request->get('q') ){
            $departments = Department::where( function($query) use ($search){
                    $query->where('department_code','LIKE',"%$search%")
                          ->orWhere('department_name','LIKE',"%$search%");
            });
        }
        return $departments->get();

    }
}
