<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SummaryChartsController extends Controller
{
    
    public function index(){
     
        //facilities by levels
        $facilities_level_state = Cache::remember('facilities_level_state', 30, function () {
            return DB::select("SELECT facility_level,COUNT(id) AS num FROM hospital_details GROUP BY facility_level order by facility_level");
        });

        $facbylevels=array();
        foreach ($facilities_level_state as $lv){
            $facbylevels[]=$lv->num;
        };

        //by ownership
        $facilities_ownership_state = Cache::remember('facilities_ownership_state', 30, function () {
            return DB::select("SELECT ownership,COUNT(id) AS num FROM hospital_details GROUP BY ownership order by ownership");
        });

        $facbyownership=array();
        foreach ($facilities_ownership_state as $own){
            $facbyownership[]=$own->num;
        };

        //get health facilities by level of care by state
        $levels_by_state = Cache::remember('levels_by_state', 30, function () {
            return DB::table('hospitals_count_by_level_state_column')
                    ->orderByRaw('state')
                    ->get();
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


        $filtered = FALSE;
        $facility_type_id=1;
        $state_id=101;

        // return view('public.statistic_charts', compact('facbylevels','facbyownership','levels_by_state',
        // 'lst_facility_types','lst_states'));
        return view('public.statistic_charts', compact('facbylevels','facbyownership','levels_by_state',
        'lst_facility_types','lst_states','facility_type_id','state_id','filtered'));
    }

    public function filter(Request $request){
        $state_id = $request->state_id;
        $facility_type_id = $request->facility_type_id;
        $filtered = TRUE;
          
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


        if ($facility_type_id==1){
            //facilities by levels
            $facilities_level_state = Cache::remember('facilities_level_state', 30, function () {
                return DB::select("SELECT facility_level,COUNT(id) AS num FROM hospital_details 
                            WHERE state_id=". $state_id ." GROUP BY facility_level order by facility_level");
            });

            $facbylevels=array();
            foreach ($facilities_level_state as $lv){
                $facbylevels[]=$lv->num;
            };

            //by ownership
            $facilities_ownership_state = Cache::remember('facilities_ownership_state', 30, function () {
                return DB::select("SELECT ownership,COUNT(id) AS num FROM hospital_details 
                            WHERE state_id=". $state_id ."  GROUP BY ownership order by ownership");
            });

            $facbyownership=array();
            foreach ($facilities_ownership_state as $own){
                $facbyownership[]=$own->num;
            };

            //get health facilities by level of care by state
            $levels_by_state = DB::table('hospitals_count_by_level_lga_column')
                        ->where('state_id',$state_id)
                        ->orderByRaw('lga')
                        ->get();
           
            return view('public.statistic_charts', compact('facbylevels','facbyownership','levels_by_state',
            'lst_facility_types','lst_states','facility_type_id','state_id','filtered'));
        }
        if ($facility_type_id==2){
           
        }
        if ($facility_type_id==3){
           
        }
        if ($facility_type_id==2){
           
        }


      
    }


    public function population_index(){

        $population_index = Cache::remember('population_index', 30, function () {
           return DB::select("SELECT state, ROUND(p.population/count(id)) AS ppf FROM hospital_details h
                                JOIN population p ON p.state_id=h.state_id
                                group by state,p.population
                                order by state");
        });
        
        $pop_index_states=array();
        $pop_index_ppf=array();

        foreach ($population_index as $indx){
            $pop_index_states[]=$indx->state;
            $pop_index_ppf[]=(int)$indx->ppf;
        };
        // dd($pop_index_ppf);

        return view('public.statistic_population_index', compact('pop_index_states','pop_index_ppf'));
    }

}
