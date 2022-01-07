<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission ;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;




class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request )
    {
        if( isset( $request->q )){
            $query = Permission::where(function( $q, $request ){
                $q->orWhere( 'id', 'LIKE', "%" . $request->q . "%" );
                $q->orWhere( 'name', 'LIKE', "%" . $request->q . "%" );
            })->get();
        } else
            $query = Permission::all();

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
            'name'=> 'required|string|unique:permissions,name'
        ]);

        if ($data->fails()) {
            $errors = $data->errors()->toArray();
            return conflict('El permiso ya existe',$errors);
        }
        $data = $data->valid();

        $p = new Permission();
        $p->name = $data['name'];
        $p->guard_name = 'api';
        $p->save();

        return ok( 'Permiso guadado correctamente', $p);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {

        $permission = Permission::find($id)??false;

        if(!$permission)
        {
            return not_found('No se encontro el permiso');
        }

        $permission->delete();
        
        return ok( 'Permiso, eliminado correctamente');

    }
}
