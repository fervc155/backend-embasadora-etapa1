<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{Answer,Quote};
class Client extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name','email','company','phone','whatsapp','social_networks'];
    protected $hidden = ['deleted_at','created_at','updated_at'];
 //   protected $with=['answers'];
    public function answers(){
        return $this->hasMany(Answer::class);

    }
        public function quotes(){
        return $this->hasMany(Quote::class);

    }
}
