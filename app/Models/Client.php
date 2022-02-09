<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','email','phone','whatsapp','social_networks'];
    protected $hidden = ['deleted_at','created_at','updated_at'];
 //   protected $with=['answers'];
    public function answers(){
        return $this->hasMany(\App\Models\Answer::class);

    }
}
