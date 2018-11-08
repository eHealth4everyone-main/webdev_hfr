<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;


class HomeController extends Controller
{

    public function index()
    {
         //get number of facilities by state
        $total_facilities_state= Cache::remember('facilities_ownership_state', 30, function () {
            return DB::select("SELECT s.short_code statecode,count(h.id) as 'value' FROM hs_hospitals h 
            JOIN ou_states s ON s.id = h.state_id GROUP BY s.short_code");
        });      
       
        return view('home',compact('total_facilities_state'));
    }


    public function getFacilitesByLGA(Request $request){
        $total_facilities_lga = DB::select("SELECT l.map_code LGA_UID,count(h.id) value 
                    FROM hs_hospitals h 
                    JOIN ou_lgas l ON l.id = h.lga_id 
                    JOIN ou_states s ON s.id=l.state_id
                    WHERE s.short_code ='".$request->state_code.
                    "'GROUP BY l.map_code");

      //  $state = DB::select("select name from ou_states where short_code ='".$request->state_code."'")->pluck('name');
        $state = DB::table('ou_states')
        ->select('name')
        ->where('short_code', $request->state_code)
        ->pluck('name');

        $result  = array();
        $result['state'] = $state;
        $result['facilities'] =  $total_facilities_lga ;

        return $result;
    }
    

}
