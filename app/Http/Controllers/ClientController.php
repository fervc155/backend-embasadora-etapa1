<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ok('',Client::all());
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
            'name'=>'required|string',
            'email'=>'required|email|unique:clients,email',
            'whatsapp'=>'nullable|string',
            'phone'=>'nullable|string',
            'social_networks'=>'nullable|json',

        ]);

        $client = Client::create($data);

        return ok('Cliente creado correctamente',$client);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        return ok('',$client);
    }
    public function showWithAnswers(Client $client)
    {
        return ok('',Client::with('answers')->whereId($client->id)->first());
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $data= $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:clients,email,'.$client->id,
            'whatsapp'=>'nullable|string',
            'phone'=>'nullable|string',
            'user_id'=>'nullable|exists:users,id',
            'social_networks'=>'nullable|json',
        ]);

        $client->name = $data['name'];
        $client->user_id = $data['user_id']??null;
        $client->email = $data['email'];
        $client->whatsapp = $data['whatsapp'];
        $client->phone = $data['phone'];
        $client->social_networks = $data['social_networks'];
        $client->save();

        return ok('cliente actualizado correctamente',$client);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return ok('Cliente eliminado correctamente');
    }
}
