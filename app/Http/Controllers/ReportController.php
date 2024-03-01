<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Client,Answer,Quote,Appointment};
use Auth;
use App\Models\{Pdf};
use DateTime;

class ReportController extends Controller
{
    public function first(Request $request){
        $user = Auth::user();
        $data = $request->validate([
            'start'=>'required|date',
            'end'=>'required|date',
        ]);
        $start= $data['start'];
        $end= $data['end'];

        $answers = Answer::where('created_at','>=',$start)->where('created_at','<=',$end);
        if($user->role!='senior')
            $answers->where(function($query) use($user){
                $query->orWhere('interviewed_by',$user->id);
                $query->orWhere('attend_by',$user->id);
            });
        $answers=$answers->get();

        $answers = Answer::where('created_at','>=',$start)->where('created_at','<=',$end);
        if($user->role!='senior')
            $answers->where(function($query) use($user){
                $query->orWhere('interviewed_by',$user->id);
                $query->orWhere('attend_by',$user->id);
            });
        $answers=$answers->get();

        $answersChanged = Answer::where('status_changed','>=',$start)->where('status_changed','<=',$end);
        if($user->role!='senior')
            $answersChanged->where(function($query) use($user){
                $query->orWhere('interviewed_by',$user->id);
                $query->orWhere('attend_by',$user->id);
            });
        $answersChanged=$answersChanged->get();


        //quotes


        $quotes = Quote::where('created_at','>=',$start)->where('created_at','<=',$end);
        if($user->role!='senior')
            $quotes->where('created_by',$user->id);
        $quotes=$quotes->get();


        $quotesChanged = Quote::where('status_changed','>=',$start)->where('status_changed','<=',$end);
        if($user->role!='senior')
            $quotesChanged->where('created_by',$user->id);
        $quotesChanged=$quotesChanged->get();


        //appointments


        $appointments = Appointment::where('created_at','>=',$start)->where('created_at','<=',$end);

        if($user->role!='senior')
            $appointments->where(function($query) use($user){
                $query->orWhere('created_by',$user->id);
                $query->orWhere('user_id',$user->id);
            });
        $appointments=$appointments->get();


        $appointmentsScheduled = Appointment::where('date','>=',$start)->where('date','<=',$end);

        if($user->role!='senior')
            $appointmentsScheduled->where(function($query) use($user){
                $query->orWhere('created_by',$user->id);
                $query->orWhere('user_id',$user->id);
            });
        $appointmentsScheduled=$appointmentsScheduled->get();

        //clients/
        $clients= Client::where('created_at','>=',$start)->where('created_at','<=',$end)->get(); 

       $report =[
            'answers_created'=>$answers->count(),

            'answers_observation'=>$answers->where('poll_status_id',1)->values()->count(),
            'answers_curious'=>$answers->where('poll_status_id',2)->values()->count(),
            'answers_potential'=>$answers->where('poll_status_id',3)->values()->count(),

            'quotes_created'=>$quotes->count(),
            'quotes_email'=>$quotesChanged->where('quote_status_id',1)->values()->count(),
            'quotes_first_call'=>$quotesChanged->where('quote_status_id',2)->values()->count(),
            'quotes_second_call'=>$quotesChanged->where('quote_status_id',3)->values()->count(),
            'quotes_third_call'=>$quotesChanged->where('quote_status_id',4)->values()->count(),
            'quotes_cancelled'=>$quotesChanged->where('quote_status_id',5)->values()->count(),
            'quotes_approved'=>$quotesChanged->where('quote_status_id',6)->values()->count(),

            'appointments_created'=>$appointments->count(),

            'appointments_scheduled'=>$appointments->count(),
            'clients'=>$clients->count(),

        ];


        if($request->downloable)
            return $report;

        return ok('',$report);
    }


    public function firstDownload(Request $request){
        $request->downloable=true;
        $report = $this->first($request);

        $report['comments'] = $request->comments??'';
        $report['start'] = (new DateTime($request->start??''))->format('Y-m-d');
        $report['end'] = (new DateTime($request->end??''))->format('Y-m-d');
        $report['user']= Auth::user()->name;

        $pdf= new Pdf('Reporte');
        $pdf->make('report.first',[
            'report'=>$report]);

        return $pdf->download();
    }
}
