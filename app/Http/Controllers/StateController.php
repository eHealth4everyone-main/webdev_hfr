<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class StateController extends Controller
{
  
    public function index()
    {
        $states = DB::table('ou_states')->get();
        return view('states.index', compact("states"));
    }

}
