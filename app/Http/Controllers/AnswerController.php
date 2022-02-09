<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Answer, PollStatus,User};

class AnswerController extends Controller
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
          $answers = Answer::with('client')->orderBy('id','DESC')->get();
        else
          $answers = Answer::with('client')->where(function($query) use($user){
            $query->where('attend_by',$user->id)
            ->orWhere('interviewed_by',$user->id);

          })->orderBy('updated_at','DESC')->get();
            

        return ok('',$answers);
    }

    public function indexStatus(PollStatus $pollStatus,$attend=null)
    {
        $user = Auth::user();


          $answers = Answer::with('client')->where('poll_status_id',$pollStatus->id)->orderBy('id','DESC');


          if($attend!=null)
          {
            if($attend==0)
                $answers->whereNull('attend_by');
            else
                $answers->where('attend_by',$attend);
          }

        return ok('',$answers->get());
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
            'poll_id'=>'required|numeric|exists:polls,id',
            'answers'=>'required|json',
        ]);

        $data['interviewed_by']= Auth()->user()->id;
        $data['poll_status_id']= PollStatus::where('name','En observacion')->first()->id;


        $answer = Answer::create($data);

        return ok('Cuestionario guardado correctamente',$answer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        return ok('',Answer::with('client')->whereId($answer->id)->first());
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Answer $answer)
    {
        $data = $request->validate([
            'answers'=>'required|json'
         ]);

        $answer->answers = $data['answers'];
        $answer->save();

        return ok('Cuestionario editado correctamente',$answer);



    }

    public function attend(Request $request,Answer $answer)
    {
   
        $user = Auth::user();
        $answer->attend_by = $user->id;
        $answer->save();

        return ok('Ahora tu atiendes este cuestionario',$answer);



    }


    public function status(Request $request,Answer $answer)
    {
        $data = $request->validate([
            'poll_status'=>'required|exists:poll_statuses,name',
            'attend_by'=>'nullable|exists:users,id',
            'client_id'=>'nullable|numeric|exists:clients,id',
        ]);

        $answer->poll_status_id = PollStatus::whereName( $data['poll_status'])->first()->id;
        $answer->attend_by = $data['attend_by']??null;
        $answer->client_id = $data['client_id']??null;
        $answer->save();

        return ok('Cuestionario editado correctamente',$answer);



    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        $answer->delete();
        return ok('Cuestionario borrado correctamente');
    }
}
