<?php

namespace App\Http\Controllers;

use App\Models\{Appointment,User,Answer,Quote,SendMail};
use Illuminate\Http\Request;
use Auth;
class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if($user->role=='senior'){
            return ok('',Appointment::all());
        }
        if($user->role=='clouser'){
            return ok('',Appointment::where('user_id',$user->id)->get());
        }
        return ok('',Appointment::where('created_by',$user->id)->get());
    }

    public function today(User $user){
        return ok('',Appointment::where(function($query) use ($user){
            $query->orWhere('created_by',$user->id);
            $query->orWhere('user_id',$user->id);
        })->where('date',date('Y-m-d'))->get());
 
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
            'user_id'=>'required|exists:users,id',
            'client_id'=>'nullable|exists:clients,id',
            'date'=>'required|date',
            'time'=>'required',
            'title'=>'required',
           'content'=>'nullable',
        ]);



        $data['created_by'] = Auth::user()->id;


        $appointment = Appointment::create($data);
        $appointment->fresh();

        if($appointment->client){

         SendMail::to($appointment->client->email, [
            'subject'=>'Se ha programado una cita',
            'text'=>[
                'Dia '.$appointment->date,
                'Hora '.$appointment->time,
                'Asunto '.$appointment->title,
                $appontment->content??'',
                'Gracias por considerarnos como aliados estratégicos para generar tu marca. Es importante que sepas que en caso de vernos favorecidos, tus productos serán realizados por ing químicos y químicos farmacéuticos y cumpliendo con todas las medidas de Bioseguridad incluyendo irradiación con rayos UV para garantizar inocuidad y libres de COVID.',
                'Quedamos atentos y a tus servicios'
                ]
            ]);
        }

        return ok('Cita creada correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        return ok('',$appointment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return ok('cita eliminada cororectamente');
    }

    public function times(Request $request,User $user){
        $date =$request->date;

        $appointments=Appointment::where('date',$date)->get();

        $hours = $appointments->map(function($appointment){
            return $appointment->time;
        });
        return ok('',$hours);
    }
}
