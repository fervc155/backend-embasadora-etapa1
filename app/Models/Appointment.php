<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{User,Client,Answer,Quote};
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory,SoftDeletes;
    protected $with=['clouser','client','created_by'];

    protected $fillable= [
            'user_id',
            'created_by',
            'client_id',
            'date',
            'time',
            'title',
            'content',
        ];


    public function clouser(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function created_by(){
        return $this->belongsTo(User::class,'created_by','id');
    }
}
