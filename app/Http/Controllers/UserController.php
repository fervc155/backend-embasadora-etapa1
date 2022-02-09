<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($role=false)
    {
        if($role)
          return ok('',User::whereHas("roles", function($q) use($role){ 
            $q->where("name",$role);
          })->get());
           
        return ok('',User::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|unique:users,email',
            'password'=>'required|string|confirmed',
            'role'=>'required|exists:roles,name',
        ]);

        $role = $data['role'];
        unset($data['role']);
        $data['password']= bcrypt($data['password']);


        $user = User::create($data);
        $user = User::where('email',$data['email'])->first()??false;
        $user->assignRole($role);

        return ok('',$user);        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return ok('',$user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|unique:users,email,'.$user->id,
            'role'=>'required|exists:roles,name',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->roles()->detach();
        $user->assignRole($data['role']);
        $user->save();

        return ok('usuario editado correctamente',$user);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return ok('Usuario eliminado correctamente');
    }
}
