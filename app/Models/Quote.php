<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Quote extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['header','title','client','email','content','first_footer','second_footer','start_validity','end_validity','created_by','client_id'];

}



