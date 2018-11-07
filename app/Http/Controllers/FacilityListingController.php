<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FacilityListingController extends Controller
{
   
    public function hospitals()
    {
      
        $facilities = DB::table('hospital_details')
        ->select('state','lga','unique_id','facility_name','facility_level','ownership')
        ->orderByRaw('state','lga','facility_name')
        ->paginate(20);

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

        return view('public.hospitalList',compact("facilities",'lst_states','lst_facility_types'));
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
