<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission as Permissions;
use Spatie\Permission\Exceptions\{ RoleAlreadyExists,PermissionDoesNotExist, PermissionAlreadyExists };
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if( isset( $request->q )){
            $query = Role::with( 'permissions' )->where(function( $q, $request ){
                $q->orWhere( 'id', 'LIKE', "%" . $request->q . "%" );
                $q->orWhere( 'name', 'LIKE', "%" . $request->q . "%" );
            })->get();
        } else
            $query = Role::with( 'permissions' )->get();
        return ok( '', $query );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store( NotarioStoreRequest $request )
    public function store( Request $request )
    {
        $data = Validator::make($request->input(),[
            'name'=> 'required|string|unique:roles,name',
            'permissions.*'=> 'string|exists:permissions,name'
        ]);

        if ($data->fails()) {
            $errors = $data->errors()->toArray();
            return conflict('Hubo un error en la validacion',$errors);
        }
        $data = $data->valid();
       

        $role = Role::create([ 'name' => $data['name'] ]);
        $permissions = Permissions::whereIn('name',$data['permissions']??[])->get();
        foreach( $permissions as $permission )
            $role->givePermissionTo( $permission );


        return ok( 'Rol guadado correctamente', Role::with( 'permissions' )->get() );
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $rol_id )
    {
       return ok( '', Role::with( 'permissions' )->findOrFail( $rol_id ) );
       
    }

    /**
     * Update the specified role  
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function update( Request $request, $rol_id )
    {
        $data = Validator::make($request->input(),[
            'name'=> 'required|string|unique:roles,name,'.$rol_id,
            'permissions.*'=> 'string|exists:permissions,name'
        ]);

        if ($data->fails()) {
            $errors = $data->errors()->toArray();
            return conflict('Hubo un error en la validacion',$errors);
        }
        $data = $data->valid();

        $role = $request->role;

        $role->name = $request->name;
        $role->save();
        $role->permissions()->detach();

    

        foreach( $data['permissions']??[] as $permission ){
            $permission = Permissions::findByName($permission);           
            $role->givePermissionTo( $permission );           
        }
           
           
     
       return ok('', Role::with( 'permissions' )->get());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        try{
            $af = Role::with( 'permissions' )->findOrFail( $id );
            Permissions::destroy( $af->permissions->pluck( 'id' )->toArray() );
            $af->revokePermissionTo( $af->permissions );
            $af->delete();
            return ok( 'Rol eliminado correctamente', Role::with( 'permissions' )->get() );
        } catch ( ModelNotFoundException $e ){
            return not_found( 'Rol no existe' );
        }
    }
}
