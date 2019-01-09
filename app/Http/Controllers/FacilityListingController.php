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
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

        //get state list
        $lst_states = Cache::remember('lst_states', 60, function () {
            return DB::table('ou_states')
                    ->select('id','name')
                    ->orderByRaw('name ASC')
                    ->get();
        });
        //get facility types
        $lst_facility_types = Cache::remember('lst_facility_types', 60, function () {
            return DB::table('lst_facility_types')
                    ->select('id','name')
                    ->get();
        });

        //set values facility list when no filter
        $state_id = 0;
        $lga_id = "";
        $facility_type_id = 1;
        $facility_name = "";
        $geo_codes = 0;

        return view('public.hospitalList',compact("facilities",'lst_states','lst_facility_types',
        'state_id','lga_id','facility_type_id','facility_name','geo_codes')); 
    }

  

    public function searchFacilities(Request $request)
    {
        // dd($request->all());
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $facility_type_id = $request->facility_type_id;
        $facility_name = $request->facility_name;
        $geo_codes = $request->geo_codes;
    
        if ($state_id == 0){
            $state_id2 = "";
        }
        else{
            $state_id2 = $state_id;
        }

        if ($geo_codes == 0){
            $cond = "<>";
            $value = 'XXX';
        }
        if ($geo_codes == 1){
            $cond = "<>";
            $value = '';
        }
        if ($geo_codes == 2){
            $cond = "=";
            $value = '';
        }
      

        if ($facility_type_id==1){

            $facilities = DB::table('hospital_details')
            ->where('state_id','like','%'.$state_id2.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->where('latitude',$cond,$value)
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

            $facilities->appends([
                'state_id'=>$request->state_id,
                'lga_id'=>$request->lga_id,
                'facility_name'=>$request->facility_name,
                'facility_type_id' => $request->facility_type_id,
                'geo_codes' => $geo_codes,
            ]);

        }

        if ($facility_type_id==2){
            $facilities = DB::table('pharmacy_details')
            ->where('state_id','like','%'.$state_id2.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->where('latitude',$cond,$value)
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

            $facilities->appends([
                'state_id'=>$request->state_id,
                'lga_id'=>$request->lga_id,
                'facility_name'=>$request->facility_name,
                'facility_type_id' => $request->facility_type_id,
                'geo_codes' => $geo_codes,
            ]);
        }
        if ($facility_type_id==3){

            $facilities = DB::table('laboratory_details')
            ->where('state_id','like','%'.$state_id2.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->where('latitude',$cond,$value)
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

            $facilities->appends([
                'state_id'=>$request->state_id,
                'lga_id'=>$request->lga_id,
                'facility_name'=>$request->facility_name,
                'facility_type_id' => $request->facility_type_id,
                'geo_codes' => $geo_codes,
            ]);
           
        }
        if ($facility_type_id==4){
            $facilities = DB::table('imaging_details')
            ->where('state_id','like','%'.$state_id2.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->where('latitude',$cond,$value)
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

            $facilities->appends([
                'state_id'=>$request->state_id,
                'lga_id'=>$request->lga_id,
                'facility_name'=>$request->facility_name,
                'facility_type_id' => $request->facility_type_id,
                'geo_codes' => $geo_codes,
            ]);
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
       
      
        return view('public.hospitalList',compact("facilities",'lst_states','lst_facility_types',
        'state_id','lga_id','facility_type_id','facility_name','geo_codes'));       
    }


    public function searchHospitals(Request $request)
    {
      
        $facility_name = $request->facility_name;

        $facilities = DB::table('hospital_details')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

        $facilities->appends([
            'facility_name'=>$request->facility_name,
        ]);

        return view('public.hospital_search',compact("facilities"));        
    }

 
    public function showDetails(Request $request)
    {
        if($request->facility_type_id==1){
            $details = DB::table('hospital_details')
            ->where('id',$request->id)
            ->get();
    
            $serv = DB::select("SELECT s.name FROM lst_hosp_services s JOIN hs_hospital_services h on h.service_id = s.id
                    where h. hospital_id='".$request->id."'");
           
            $services = array();
            
            foreach ($serv as $s){
                $services[] = $s->name;
            };

            $result  = array();
            $result['details'] = $details;
            $result['services'] =  $services;

            return  $result;
           
        }
            
    }

}
