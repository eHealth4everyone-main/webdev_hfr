<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function adminhome(){
        $factypes = DB::table('tbl_signatures')
                     ->select(DB::raw('fac_tpye,count(*) as total'))
                     ->groupBy('fac_tpye')
                     ->get();
       
        $states = DB::table('tbl_signatures')
                     ->join('tbl_state', 'tbl_signatures.state', '=', 'tbl_state.state_id')
                     ->select(DB::raw('tbl_state.state as sta,count(*) as total'))
                     ->groupBy('sta')
                     ->orderBy('sta','asc')
                     ->get();
       
        $state_name=array();
        $num_of_fac=array();


        foreach ($states as $state){
            $state_name[]=$state->sta;
            $num_of_fac[]=$state->total;
        };
                     
        return view("admin_dashboard",compact('factypes','state_name','num_of_fac'));
    }

    public function userhome(){
        $factypes = DB::table('tbl_signatures')
                     ->select(DB::raw('fac_tpye,count(*) as total'))
                     ->groupBy('fac_tpye')
                     ->get();
       
        $states = DB::table('tbl_signatures')
                     ->join('tbl_state', 'tbl_signatures.state', '=', 'tbl_state.state_id')
                     ->select(DB::raw('tbl_state.state as sta,count(*) as total'))
                     ->groupBy('sta')
                     ->orderBy('sta','asc')
                     ->get();
       
        $state_name=array();
        $num_of_fac=array();


        foreach ($states as $state){
            $state_name[]=$state->sta;
            $num_of_fac[]=$state->total;
        };
                     
        return view("home",compact('factypes','state_name','num_of_fac'));
    }
}
