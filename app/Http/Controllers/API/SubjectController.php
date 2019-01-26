<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return Subject::latest()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate inputs
        $this->validate($request,[
            'subject_code' => 'required|unique:subjects|max:6',
            'subject_name' => 'required|string|max:191|unique:subjects',
            'credit_hours' => 'required|integer'
        ]);
        
         return Subject::create([
            'subject_code' => $request['subject_code'],
            'subject_name' => $request['subject_name'],
            'credit_hours' => $request['credit_hours'],
        ]);
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
        $subject = Subject::findOrFail($id);

        $this->validate($request,[
            'subject_code' => 'sometimes|max:6',
            'subject_name' => 'required',
            'credit_hours' => 'required|integer'
        ]);
        $subject->update($request->all());

        return ['message'=>'subject updated'];

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $subject = Subject::findOrFail($id);
         $subject->delete();

        return ['message' => 'Subject deleted'];
    }

    //search subject table
    public function search(Request $request)
    {
        if( $search = $request->get('q') ){
            $subjects = Subject::where( function($query) use ($search){
                    $query->where('subject_name','LIKE',"%$search%")
                          ->orWhere('subject_code','LIKE',"%$search%")
                          ->orWhere('credit_hours','LIKE',"%$search%");
            });//*->paginate(20);
            
        }
        return $subjects->get();

    }
}
