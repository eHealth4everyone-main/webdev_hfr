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
        $total_facilities_state= Cache::remember('total_facilities_home', 30, function () {
            return DB::select("SELECT s.short_code statecode,count(h.id) as 'value' FROM hs_hospitals h 
            JOIN ou_states s ON s.id = h.state_id GROUP BY s.short_code");
        });      

            //facilities by levels
        $facilities_level_state = Cache::remember('facilities_level_home', 30, function () {
            return DB::select("SELECT facility_level as name,COUNT(id) AS y FROM hospital_details GROUP BY facility_level order by facility_level");
        });
 
        //by ownership
        $facilities_ownership_state = Cache::remember('facilities_ownership_home', 30, function () {
            return DB::select("SELECT ownership as name,COUNT(id) AS y FROM hospital_details GROUP BY ownership order by ownership");
        });
       
        return view('public.home',compact('total_facilities_state','facilities_ownership_state','facilities_level_state'));
    }


    public function getFacilitesByLGA(Request $request){
        $total_facilities_lga = DB::select("SELECT l.map_code LGA_UID,count(h.id) value 
                    FROM hs_hospitals h 
                    JOIN ou_lgas l ON l.id = h.lga_id 
                    JOIN ou_states s ON s.id=l.state_id
                    WHERE s.short_code ='".$request->state_code.
                    "'GROUP BY l.map_code");

   
        $state = DB::table('ou_states')
        ->select('name')
        ->where('short_code', $request->state_code)
        ->pluck('name');

        $result  = array();
        $result['state'] = $state;
        $result['facilities'] =  $total_facilities_lga ;

        return $result;
    }

    public function getFacilitesGMap(Request $request)
    {   
        //get lga id and name
        $lga = DB::table('ou_lgas')
        ->select('id','name')
        ->where('map_code', $request->lga_code)
        ->get();
        
         $lga_details = array();
 
         foreach ($lga as $l){
             $lga_details[0] = $l->id; //lga id
             $lga_details[1] = $l->name; //lga name
         };

     
        $facilities = DB::select("SELECT id,unique_id,facility_name,latitude,longitude 
                        FROM hospital_details where latitude != '' and 
                        lga_id='". $lga_details[0] . "'");
       
        $lga_name =  $lga_details[1];

        $result  = array();
        $result['lga_name'] = $lga_name;
        $result['facilities_list'] =  $facilities;

        return  $result;
    }

    
    
}
