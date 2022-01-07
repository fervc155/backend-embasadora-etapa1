<?php

namespace App\Http\Middleware\api;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class FindRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $role_id =$request->input('rol_id')?? ($request->get('rol_id') ?? ( $request->route('rol_id') ??  -1 ));
 
        $role = Role::find($role_id)?? false;

        if(!$role)
            return bad_request('El rol no existe');
        
        $request->role=$role;
        return $next($request);
    }
}
