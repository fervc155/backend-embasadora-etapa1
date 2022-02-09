<?php

namespace App\Http\Controllers;

use App\Models\PollStatus;
use Illuminate\Http\Request;

class PollStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ok('',PollStatus::all());
    }

}
