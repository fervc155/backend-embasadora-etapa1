<?php

namespace App\Models;

use App\Models\Token;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable implements JWTSubject
{
    Use SoftDeletes, Notifiable, HasFactory, Notifiable,hasRoles;
   
    public $incrementing = false;
    protected $keyType = 'uuid';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function checkPassword($password){
        return Hash::check($password, $this->password);

    }
    
    public function token(){
        return $this->hasOne(Token::class,'user_id')->where('revoked',0)->whereNull('deleted_at');    
    }

    public function tokens(){
        return $this->hasMany(Token::class,'user_id');  
    }


    public function saveToken($token){

        $jwt= Token::decode($token);

        $tokenData=[
            'expires_at'=>Date("Y-m-d H:i:s",$jwt['payload']['exp'] ),
            'jti'=>$jwt['payload']['jti'],
            'revoked'=>0,
        ];

        $this->tokens()->update([
            'revoked'=>1,
            'user_id'=>$this->id
        ]);
        $this->tokens()->create($tokenData);

    }
}
