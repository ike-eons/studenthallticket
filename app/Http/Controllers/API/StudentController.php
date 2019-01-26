<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Student::latest()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate student data
        $request->validate([
                'index_no'=>'required|unique:students|max:11',
                'firstname'=>'required',
                'lastname'=>'required',
                'department'=>'required',
                'course'=>'required',
                'regular_or_weekend'=>'required',
                'nationality'=>'required'
        ]);
       return Student::create([
            'index_no' => $request['index_no'],
            'firstname' => $request['firstname'],
            'middlename' => $request['middlename'],
            'lastname' => $request['lastname'],
            'department' => $request['department'],
            'course' => $request['course'],
            'regular_or_weekend' => $request['regular_or_weekend'],
            'nationality' => $request['nationality'],
        ]);
        //return ['message'=>'student creddddddddd'];
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
                'index_no'=>'required|max:11',
                'firstname'=>'required',
                'lastname'=>'required',
                'department'=>'required',
                'course'=>'required',
                'regular_or_weekend'=>'required',
                'nationality'=>'required'
        ]);

        $student->update($request->all());
        return ['message'=>'student updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return ['message'=>'student deleted ...'];
    }

      public function search(Request $request)
    {
        if( $search = $request->get('q') ){
            $students = Student::where( function($query) use ($search){
                    $query->where('index_no','LIKE',"%$search%")
                          ->orWhere('department','LIKE',"%$search%")
                          ->orWhere('firstname','LIKE',"%$search%")
                          ->orWhere('lastname','LIKE',"%$search%")
                          ->orWhere('middlename','LIKE',"%$search%")
                          ->orWhere('nationality','LIKE',"%$search%")
                          ->orWhere('course','LIKE',"%$search%")
                          ->orWhere('regular_or_weekend','LIKE',"%$search%");
            });//*->paginate(20);
            
        }
        return $students->get();

    }
}
