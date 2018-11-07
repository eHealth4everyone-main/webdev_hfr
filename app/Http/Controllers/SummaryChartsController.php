<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SummaryChartsController extends Controller
{
    
    public function index(){

        $facilities_by_state = Cache::remember('facilities_by_state', 30, function () {
            return DB::select("SELECT state, count(id) as num FROM hospital_details group by state");
        });
        
        $state_name=array();
        $num_of_fac=array();

        foreach ($facilities_by_state as $fac){
            $state_name[]=$fac->state;
            $num_of_fac[]=$fac->num;
        };

        //by levels
        $facilities_level_state = Cache::remember('facilities_level_state', 30, function () {
            return DB::select("SELECT facility_level,COUNT(id) AS num FROM hospital_details GROUP BY facility_level order by facility_level");
        });

        $facbylevels=array();
        foreach ($facilities_level_state as $lv){
            $facbylevels[]=$lv->num;
        };

        //by ownership
        $facilities_ownership_state = Cache::remember('facilities_ownership_state', 30, function () {
            return DB::select(" SELECT ownership,COUNT(id) AS num FROM hospital_details GROUP BY ownership order by ownership");
        });

        $facbyownership=array();
        foreach ($facilities_ownership_state as $own){
            $facbyownership[]=$own->num;
        };

        //levels by state
        $levels_by_state = Cache::remember('levels_by_state', 30, function () {
            return DB::table('hospitals_count_by_level_state_column')->get();
        });
        
        //get state list
        $lst_states = Cache::remember('lst_states', 30, function () {
            return DB::table('ou_states')
                    ->select('id','name')
                    ->orderByRaw('name ASC')
                    ->get();
        });
        //get facility types
        $lst_facility_types = Cache::remember('lst_facility_types', 30, function () {
            return DB::table('lst_facility_types')
                    ->select('id','name')
                    ->get();
        });


        return view('public.statistic_charts', compact('state_name','num_of_fac','facbylevels','facbyownership',
        'levels_by_state','lst_facility_types','lst_states'));
    }

}
