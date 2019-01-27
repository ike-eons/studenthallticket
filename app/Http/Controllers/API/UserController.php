<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash; 

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return User::latest()->paginate(10); 
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
            'name' => 'required|unique:users|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6'
        ]);


        //return User::create($request->all());
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'password' => Hash::make($request['password']),
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

    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6'
        ]);

        $user->update($request->all());
        return ['message'=>'updated user info'];
    }

    public function destroy($id)
    {
        $user = User::findorfail($id);
        $user->delete();

        return ['message' => 'user deleted'];
    }

     public function search(Request $request)
    {
        if( $search = $request->get('q') ){
            $users = User::where( function($query) use ($search){
                    $query->where('name','LIKE',"%$search%")
                          ->orWhere('email','LIKE',"%$search%")
                          ->orWhere('type','LIKE',"%$search%");
            });//*->paginate(20);
            
        }
        return $users->get();

    }
}
