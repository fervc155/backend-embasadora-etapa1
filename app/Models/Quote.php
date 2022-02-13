<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\{QuoteStatus,Client,Answer};

class Quote extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['header','title','phone','client_name','email','content','currency','first_footer','second_footer','start_validity','end_validity','created_by','client_id','quote_status_id','answer_id'];

    protected $with = ['status','client','answer'];

    public function status(){
        return $this->belongsTo(QuoteStatus::class,'quote_status_id');
    }

    public function client(){
        return $this->belongsTo(Client::class,'client_id');
    }

    public function answer(){
        return $this->belongsTo(Answer::class,'answer_id');
    }
}



