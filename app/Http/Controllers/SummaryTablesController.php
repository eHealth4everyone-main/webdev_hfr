<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class SummaryTablesController extends Controller
{
    public function index(){      
       
        $results = DB::select("SELECT  
            (SELECT count(id) FROM hospital_details) AS hosp,
            (SELECT count(id) FROM  laboratory_details) AS lab,
            (SELECT count(id) FROM pharmacy_details) AS pharma,
            (SELECT count(id) FROM imaging_details) AS radio
             FROM dual");

        $total_num_fac=array();

        foreach ($results as $r){
            $total_num_fac[0] = $r->hosp;
            $total_num_fac[1] = $r->lab;
            $total_num_fac[2] = $r->pharma;
            $total_num_fac[3] = $r->radio;
        };

       
        $levels_by_state = Cache::remember('levels_by_state', 30, function () {
            return DB::table('hospitals_count_by_level_state_column')->get();
        });

        $ownerships_by_state = Cache::remember('ownerships_by_state', 30, function () {
            return DB::table('hospitals_count_by_ownership_state_column')->get();
        });
    
        $levels_ownership_by_state = Cache::remember('levels_ownership_by_state', 30, function () {
            return DB::table('hospitals_count_by_ownership_level_state_column')->get();
        });
        
        $lst_states = Cache::remember('lst_states', 30, function () {
            return DB::table('ou_states')
                    ->select('id','name')
                    ->orderByRaw('name ASC')
                    ->get();
        });

        $lst_facility_types = Cache::remember('lst_facility_types', 30, function () {
            return DB::table('lst_facility_types')
                    ->select('id','name')
                    ->get();
        });

        return view('public.statistics', compact('total_num_fac','ownerships_by_state',
        'levels_by_state','levels_ownership_by_state','lst_facility_types','lst_states'));
    }

}
