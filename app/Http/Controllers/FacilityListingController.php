<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityListingController extends Controller
{
   
    public function hosptials()
    {
        $facilities = DB::table('hospitals_details')->get();
        return view('public.hospitalList', compact("facilities"));
    }

    public function index(Request $request)
    {
       
        $type=0;

        if ($request->facilitytype==1){
            $facilities = DB::table('hospitals_details')->get();
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

    
        $fac_levels = DB::table('num_hosp_by_level_state_clm')->get();
        $fac_ownerships = DB::table('num_hosp_by_ownership_state_clm')->get();
       
        return view('public.statistics', compact('results','fac_ownerships','fac_levels'));

    }

    public function statistics_charts(){

        $num_failities = DB::select("SELECT state, count(id) as num FROM hospitals_details group by state");

        $state_name=array();
        $num_of_fac=array();

        foreach ($num_failities as $fac){
            $state_name[]=$fac->state;
            $num_of_fac[]=$fac->num;
        };

        //by levels
        $facbylevels=array();
        $facbylevel=DB::select("SELECT level,COUNT(id) AS num FROM hospitals_details GROUP BY level order by level");
       
        foreach ($facbylevel as $lv){
            $facbylevels[]=$lv->num;
        };

        //by ownership
        $facbyownership=array();
        $facbyown=DB::select(" SELECT ownership,COUNT(id) AS num FROM hospitals_details GROUP BY ownership order by ownership");
       
        foreach ($facbyown as $own){
            $facbyownership[]=$own->num;
        };
       
       
        return view('public.statistic_charts', compact('state_name','num_of_fac','facbylevels','facbyownership'));

    }


    
    public function search (Request $request)
    {
    
        $type=0;

        if ($request->facilitytype==1){
            $facilities = DB::table('hospitals_details')
                ->where('facility_name', 'like', '%'. $request->fac_name . '%')
                ->get();
            $type = 1;
        }

        if ($request->facilitytype==2){
            $facilities = DB::table('laboratory')
                ->where('facility_name', 'like', '%'. $request->fac_name . '%')
                ->get();
            $type = 2;
        }
        if ($request->facilitytype==3){
            $facilities = DB::table('pharmacies')
                ->where('facility_name', 'like', '%'. $request->fac_name . '%')
                ->get();
            $type = 3;
        }
        if ($request->facilitytype==4){
            $facilities = DB::table('radiologies')
                ->where('facility_name', 'like', '%'. $request->fac_name . '%')
                ->get();
            $type = 4;
        }

        return view('public.search', compact("facilities","type"));
        
    }

}
