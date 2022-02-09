<?php

namespace App\Http\Controllers;

use App\Models\{User,Quote};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Pdf,SendMail};
class QuoteController extends Controller
{

    public function __construct(){
        Auth::login(User::find(1));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ok('',Quote::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $data = $request->validate([
            'client_id'=>'nullable|exists:clients,id',
            'client'=>'required|string',
            'email'=>'required|email',
            'content'=>'required|json',
            'start_validity'=>'required|date',
            'end_validity'=>'required|date',
            'header'=>'required|string',
            'first_footer'=>'required|string',
            'second_footer'=>'required|string',
            'title'=>'required|string'
        ]);



        $data['created_by']= Auth()->user()->id;

        $quote = Quote::create($data);


        $pdf= new Pdf('cotizacion');
        $pdf->make('quote',[
            'quote'=>$quote]);

        SendMail::to($data['email'], [
            'subject'=>'Haz recibido una cotizacion',
            'text'=>['Se ha generado una nueva cotizacion a este correo electronico, descargala de los adjuntos']
        ],$pdf);


        return ok('Cotizacion creada correctamente',$quote);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function show(Quote $quote)
    {
        return ok('',$quote);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quote $quote)
    {

        return ['bad'];
            $data = $request->validate([
                'answers'=>'required|json',
                'client_id'=>'nullable|exists:users,id',
                'title'=>'string|required'
            ]);

            $data = (object) $data;

            $quote->answers = $data['answers'];
            $quote->client_id = $data['client_id'];
            $quote->title = $data['title'];
            $quote->save();

            return ok('Cotizacion editada correctamente',$quote);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quote  $quote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quote $quote)
    {
        $quote->delete();
        
        return ok('Cotizacion eliminada correctamente');
    }


    public function download(Quote $quote){

       // return view('pdf.quote')->with('quote',$quote);

        $pdf= new Pdf('cotizacion');
        $pdf->make('quote',[
            'quote'=>$quote]);

        return $pdf->download();


    }
}
