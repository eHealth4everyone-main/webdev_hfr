<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityListingController extends Controller
{
   
    public function hosptials()
    {
        $facilities = DB::table('view_hospitals')->get();
        return view('public.hospitalList', compact("facilities"));
    }

    public function index(Request $request)
    {
       
        $type=0;

        if ($request->facilitytype==1){
            $facilities = DB::table('view_hospitals')->get();
            $type = 1;
        }

        if ($request->facilitytype==2){
            $facilities = DB::table('laboratory')->get();
            $type = 2;
        }
        if ($request->facilitytype==3){
            $facilities = DB::table('pharmacies')->get();
            $type = 3;
        }
        if ($request->facilitytype==4){
            $facilities = DB::table('radiologies')->get();
            $type = 4;
        }

        return view('public.faclist', compact("facilities","type"));
        
    }

    public function statistics(){

        $results = DB::select("SELECT  
            (SELECT count(id) FROM hospitals_details) AS hosp,
            (SELECT count(id) FROM laboratory) AS lab,
            (SELECT count(id) FROM pharmacies) as pharma,
            (SELECT count(id) FROM radiologies) as radio
             FROM dual");

        $num_failities = DB::select("SELECT state, count(id) as num FROM hospitals_details group by state");

        $state_name=array();
        $num_of_fac=array();

        foreach ($num_failities as $fac){
            $state_name[]=$fac->state;
            $num_of_fac[]=$fac->num;
        };

        $fac_levels = DB::table('num_hosp_by_level_state_clm')->get();
        $fac_ownerships = DB::table('num_hosp_by_ownership_state_clm')->get();
       
        return view('public.statistics', compact('results','state_name','num_of_fac','fac_ownerships','fac_levels'));

    }

  
}
