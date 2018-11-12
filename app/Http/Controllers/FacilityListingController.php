<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class FacilityListingController extends Controller
{
   
    public function index()
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

  

    public function searchFacilities(Request $request)
    {
        // dd($request->all());
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $facility_type_id = $request->facility_type_id;
        $facility_name = $request->facility_name;

        if ($state_id == 0){
            $state_id = "";
        }
        if ($facility_type_id==1){

            $facilities = DB::table('hospital_details')
            ->select('state','lga','unique_id','facility_name','facility_level','ownership')
            ->where('state_id','like','%'.$state_id.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

            $facilities->appends([
                'state_id'=>$request->state_id,
                'lga_id'=>$request->lga_id,
                'facility_name'=>$request->facility_name,
                'facility_type_id' => $request->facility_type_id,
            ]);

        }

        if ($facility_type_id==2){
           
        }
        if ($facility_type_id==3){
       
           
        }
        if ($facility_type_id==4){
           
        }


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


    public function searchHospitals(Request $request)
    {
      
        $facility_name = $request->facility_name;

        $facilities = DB::table('hospital_details')
        ->select('state','lga','unique_id','facility_name','facility_level','ownership')
        ->Where('facility_name', 'like', '%' .  $facility_name . '%')
        ->orderByRaw('state','lga','facility_name')
        ->paginate(20);

        $facilities->appends([
            'facility_name'=>$request->facility_name,
        ]);

        return view('public.hospital_search',compact("facilities"));        
    }

   

}
