<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
           
        return ok('',$this->setMany(User::all()));
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
            'user_id'=>'nullable|exists:users,id',
        ]);

        $role = $data['role'];

        if($role!='hostess')
            unset($data['user_id']);

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
        return ok('',$user->withEmployees());
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
        $auth = Auth::user();

        if($auth->role!='senior')
            if($auth->id !=$user->id)
               return forbidden('No es tu usuario');
 
        $data = $request->validate([
            'name'=>'required|string',
            'email'=>'required|unique:users,email,'.$user->id,
            'role'=>'required|exists:roles,name',
            'user_id'=>'nullable|exists:users,id',

        ]);


        if($data['role']=='hostess')
            $user->user_id=$data['user_id']??null;
        else
            $user->user_id=null;

        $user->name = $data['name'];
        $user->email = $data['email'];

        if($auth->role=='senior'){
        $user->roles()->detach();
        $user->assignRole($data['role']);
        }
        $user->save();

        return ok('usuario editado correctamente',$user);


    }

    public function changePassword(Request $request,User $user){
        $validate= [
            'password'=>'required|string|confirmed',
            'old_password'=>'required|string',
        ];

        $auth=Auth::user();
        if($auth->role=='senior'){
            unset($validate['old_password']);          
        }else {
            if($auth->id!=$user->id)
                return unauthorized('No es tu usuario');
        }

        $data = $request->validate($validate);

        if($auth->role!='senior'){
            if(!$auth->checkPassword($data['old_password']))
                return error_validate(null,[
                    'old_password'=>['Contraseña incorrecta']
                ]
                );
        }

       $user->password = bcrypt($data['password']);
       $user->save();

       return ok('Clave cambiada con exito',$user->fresh());
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


    private function setMany($users){
        $allUsers =User::all();
        
        foreach($users as &$user){
            $user->boss = $allUsers->where('id',$user->user_id)->first()??null;
            $user->employees =$allUsers->where('user_id',$user->id)->values();
        }
        return $users;
    } 
}
