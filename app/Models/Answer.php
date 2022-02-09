<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Answer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['poll_id','poll_status_id','interviewed_by','answers'];

    protected $appends = ['status'];

    protected $with=['poll','interviewer','attend'];

    public function getStatusAttribute(){
        return $this->pollStatus->name;
    }

    public function pollStatus(){
        return $this->belongsTo(\App\Models\PollStatus::class);
    }

    public function poll(){
        return $this->belongsTo(\App\Models\Poll::class);
    }
    public function client(){
        return $this->belongsTo(\App\Models\Client::class);
    }

    public function interviewer(){
        return $this->belongsTo(\App\Models\User::class,'interviewed_by');
    }

    public function attend(){
        return $this->belongsTo(\App\Models\User::class,'attend_by');
    }
}
