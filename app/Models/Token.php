<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
class Token extends Model
{
    use Uuid,HasFactory,SoftDeletes;

    protected $fillable = ['expires_at','jti','revoked'];

    public static function decode($token){
        $tokenParts = explode(".", $token); 

        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
            
        $jwt=[];
        $jwt['header'] = json_decode($tokenHeader);
        $jwt['payload'] = json_decode($tokenPayload,true);

        return $jwt;
    }

    public static function check($token){
        $jwt = Token::decode($token);

         if($jwt['payload']==null)
            return false;
        

        $valid =DB::table('tokens')->where('revoked',0)->where('jti',$jwt['payload']['jti'])->first()??false;
        if($valid)
           return User::with('roles')->where('id',$jwt['payload']['user']['id'])->first();
       

        return false;

    }
    public function revoke(){
        $this->revoked=0;
        $this->deleted_at= now();
        $this->save();
    }
}
