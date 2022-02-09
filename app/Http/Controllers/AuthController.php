<?php

namespace App\Http\Controllers;

use App\Models\{User,SendMail};
use Illuminate\Http\Request;
use DB;
class AuthController extends Controller
{
    public function register(Request $request)
    {

        $data= $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $user = User::where('email',$data['email'])->first();
        $user->assignRole('senior');
        return ok('usuario creado correctamente',$user);
    }

    public function login(Request $request)
    {
        $login_credentials= $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        $today= strtotime("now");
        $exp= strtotime("+1 days");
        $ttl = $exp - $today;

        $user = User::with('roles')->where('email',$login_credentials['email'])->get()->first()??false;


        if ($token = auth()
            ->claims([
                'user'=>$user
            ])
            ->setTTL($ttl)
            ->attempt($login_credentials)) {
            
            $user->saveToken($token);

            //now return this token on success login attempt
            return ok('Sesion iniciada correctamente',$token);
        } else {
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return unauthorized('Tus claves de acceso son incorrectas');
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user->token->revoke();
        return response()->json(['message' => 'Sesion cerrada correctamente']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh(Request $request)
    {
        $user = $request->user;
        $token = auth()
            ->claims([
                'user'=>$user
            ])
            ->setTTL($ttl)
            ->login($user);
            
        $user->saveToken($token);

        return ok('Token refrescado correctamente',$user_login_token);
    }

    public function check(Request $request){
        return ok('',$request->user);
    }

    public function recoverPassword(Request $request){
        $data = $request->validate([
            'email'=>'required|email'
        ]);

        $user = User::whereEmail($data['email'])->first()??false;
            if(!$user)
            return ok();

        $token = uniqid(true).uniqid(true).uniqid(true);
        $token_expire_at =  date('Y-m-d H:i:s',strtotime('now + 1 days'));

        $user->token =$token;
        $user->token_expire_at=$token_expire_at;
        $user->save();
        $url = env('FRONT_URL').'auth/cambiar-password/'.$token;


        SendMail::user($user,[
            'text'=>[
                'Da click en el siguiente boton para cambiar tu contraseña, el link vence en 24 horas'
            ],
            'subject'=>'Solicitud para cambiar contraseña',
            'url'=>$url,
            'btn_name'=>'Cambiar contraseña'
        ]
        );

        return ok('correo enviado');
        

    


    }

    public function changePassword(Request $request){
        $data = $request->validate([
            'password'=>'required|min:8|string|confirmed',
            'token'=>'required|string',
        ]);


        $user = User::where('token',$data['token'])
        ->where('token_expire_at','>=',now())
        ->first()??false;

        if(!$user)
            return not_found('usuario no encontrado');


        $user->password = bcrypt($data['password']);
        $user->token=null;
        $user->token_expire_at=null;
        $user->save();

        return ok('contraseña cambiada correctamente');
    }
}
