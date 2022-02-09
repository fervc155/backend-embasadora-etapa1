<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;

class Pdf extends Model
{


    public $pdf;
    public $name;

    public function getfullnameAttribute(){
        return $this->name.'.pdf';
    }
    public function __construct($name='download'){
        $this->name =$name;
        $this->pdf= array();

    }
    public function make($view,$data,$download=false){
        $this->pdf = DomPdf::loadView('pdf.'.$view, $data);
        $this->pdf->setPaper('letter', 'portrait');

        if($download){
           return $this->download();
        }

    }

    public function download($name=false){
        if($name){
            $this->name=$name;
        }
        return $this->pdf->download($this->name.'.pdf');
    }

    public function output(){
         $this->pdf->render();
         return $this->pdf->output();

    }

}
