<?php

namespace App\Http\Controllers;

use App\Models\{User,Quote,QuoteStatus};
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
        $user = Auth::user();
        if($user->role=='senior')
          return ok('',Quote::all());

        return ok('',Quote::where('created_by',$user->id)->get());
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
            'answer_id'=>'nullable|exists:answers,id',
            'client_name'=>'required|string',
            'email'=>'required|email',
            'phone'=>'required',
            'currency'=>'required|string',
            'content'=>'required|json',
            'start_validity'=>'required|date',
            'end_validity'=>'required|date',
            'header'=>'required|string',
            'first_footer'=>'required|string',
            'second_footer'=>'required|string',
            'title'=>'required|string'
        ]);

        $data['created_by']= Auth()->user()->id;
        $data['quote_status_id']= 1;
        $quote = Quote::create($data);


        $pdf= new Pdf('cotizacion');
        $pdf->make('quote',[
            'quote'=>$quote]);



        SendMail::to($data['email'], [
            'subject'=>'Haz recibido una cotizacion',
            'text'=>[
                'Gracias por considerarnos como aliados estratégicos para generar tu marca. Es importante que sepas que en caso de vernos favorecidos, tus productos serán realizados por ing químicos y químicos farmacéuticos y cumpliendo con todas las medidas de Bioseguridad incluyendo irradiación con rayos UV para garantizar inocuidad y libres de COVID.',
                'Quedamos atentos y a tus servicios'
]
        ],$pdf);


        return ok('Cotizacion creada correctamente',$quote->fresh());
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

        $data = $request->validate([
            'client_id'=>'nullable|exists:users,id',
        ]);

        $quote->client_id = $data['client_id'];
        $quote->save();

        return ok('Cotizacion editada correctamente',$quote->fresh());


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

    public function status(Request $request,Quote $quote, QuoteStatus $quoteStatus)
    {

        $quote->quote_status_id = $quoteStatus->id;
        $quote->status_changed= date('Y-m-d');
        $quote->save();

        return ok('Status cambiado',$quote->fresh());
    }


    public function download(Quote $quote){

       // return view('pdf.quote')->with('quote',$quote);

        $pdf= new Pdf('cotizacion');
        $pdf->make('quote',[
            'quote'=>$quote]);

        return $pdf->download();


    }
}
