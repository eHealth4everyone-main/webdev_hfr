<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FacilityListingController extends Controller
{
   
    public function index()
    {
       
        $facilities = DB::table('hospital_details')
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->paginate(20);

        //set values facility list when no filter

        list($state_id, $lga_id, $facility_type_id,$facility_name, $geo_codes, $ward_id, 
            $facility_level_id , $ownership_id,$operational_status_id,$registration_status_id,
            $license_status_id,$service_type) = [1,1,1,"",0,0,0,0,0,0,0,0];

      
        
        return view('public.facilities_list',compact('facilities',
        'state_id', 'lga_id', 'facility_type_id','facility_name', 'geo_codes', 'ward_id','facility_level_id', 
        'ownership_id','operational_status_id','registration_status_id', 'license_status_id','service_type'));    
    }

    public function updates()
    {
        $facilities="none";
        
        return view('public.facilities_updates',compact('facilities'));    
    }

    public function getUpdates(Request $request)
    {
     
       //New Facilities Created This Month
        if ($request->report == 1){
            $facilities = DB::table('hospital_details')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();   
            $report=$facilities->count()." Facilities were created this Month";    
        }

        //New Facilities Created Last Month
        if ($request->report == 2){
            $facilities = DB::table('hospital_details')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->startOfMonth()])
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();   
            $report=$facilities->count()." Facilities were created in the last Month";
        }

        //New Facilities Created Last 3 Months
        if ($request->report == 3){
            $facilities = DB::table('hospital_details')
            ->whereBetween('created_at', [Carbon::now()->subMonth(4), Carbon::now()->subMonth(1)])
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();
            $report=$facilities->count()." Facilities were created in the last 3 Month";
        }

        //Facilities Updated This Month 
        if ($request->report == 4){
            $facilities = DB::table('hospital_details')
            ->where('updated_at', '>=', Carbon::now()->startOfMonth())
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();  

            $report=$facilities->count()." Facilities were updated this Month";
        }

        //Facilities Updated Last Month
        if ($request->report == 5){
            $facilities = DB::table('hospital_details')
            ->whereBetween('updated_at', [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->startOfMonth()])
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();  
            $report=$facilities->count()." Facilities were updated in the last Month";
        }
    
        //Facilities Updated Last 3 Month
        if ($request->report == 6){
            $facilities = DB::table('hospital_details')
            ->whereBetween('updated_at', [Carbon::now()->subMonth(4), Carbon::now()->subMonth(1)])
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();  
            $report=$facilities->count()." Facilities were updated in the last 3 Month";
        }


     


        
        return view('public.facilities_updates',compact('facilities','report'));     
    }
  
    public function getHospitals(Request $request)
    {
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $ward_id = $request->ward_id;
        $facility_name =$request->facility_name;
        $facility_type_id = $request->facility_type_id;
        $facility_level_id = $request->facility_level_id;
        $ownership_id = $request->ownership_id;
        $operational_status_id = $request->operational_status_id;
        $registration_status_id = $request->registration_status_id;
        $license_status_id = $request->license_status_id;
    
        if ( $request->geo_codes == 0){
            $cond = "<>";
            $value = 'XXX';
        }
        if ( $request->geo_codes == 1){
            $cond = "<>";
            $value = '';
        }
        if ( $request->geo_codes == 2){
            $cond = "=";
            $value = '';
        }

        if ($request->service_type == 1){
            $outpatient = 'Yes';
            $inpatient = '';
        }elseif($request->service_type == 2){
            $outpatient = '';
            $inpatient = 'Yes';
        } else{
            $outpatient = '';
            $inpatient = '';
        }

        if ($ward_id == 0){
            $ward_id ='';
        }
        if($facility_level_id == 0){
            $facility_level_id = '';
        }
        if($ownership_id==0 ){
            $ownership_id=''; 
        }
        if($operational_status_id==0){
            $operational_status_id='';
        }
        if($registration_status_id==0){
            $registration_status_id='';
        }
        if($license_status_id==0){
            $license_status_id='';
        }

        if(!empty($request->services)){
            $hospital = DB::select("SELECT DISTINCT hospital_id FROM hs_hospital_services 
            WHERE service_id IN (". implode (",", $request->services) . ")");

            $hospital_with_services=[];
            foreach ($hospital as $h){
                $hospital_with_services[]= $h->hospital_id;
            }
            
        }else{
            $hospital = DB::select("SELECT id FROM hospital_details");

            $hospital_with_services=[];
            foreach ($hospital as $h){
                $hospital_with_services[]= $h->id;
            }
        }

        $facilities = DB::table('hospital_details')
            ->where('state_id','like','%'.$state_id.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->where(DB::Raw("IFNULL(ward_id, '')"),'like','%'.$ward_id.'%')
            ->where('facility_level_id','like','%'.$facility_level_id.'%')
            ->where('ownership_id','like','%'.$ownership_id.'%')
            ->where('operational_status_id','like','%'.$operational_status_id.'%')
            ->where('registration_status_id','like','%'.$registration_status_id.'%')
            ->where('license_status_id','like','%'.$license_status_id.'%')
            ->where(DB::Raw("IFNULL(outpatient, '')"),'like','%'.$outpatient.'%')
            ->where(DB::Raw("IFNULL(inpatient, '')"),'like','%'.$inpatient.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->where('latitude',$cond,$value)
            ->wherein('id',$hospital_with_services)
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->paginate(20);

        //  dd($facilities);

        $facilities->appends([
            'state_id' => $request->state_id,
            'lga_id' => $request->lga_id,
            'ward_id' => $request->ward_id,
            'facility_name' =>$request->facility_name,
            'geo_codes' => $request->geo_codes,
            'facility_type_id' => $request->facility_type_id,
            'facility_level_id' => $request->facility_level_id,
            'ownership_id' => $request->ownership_id,
            'operational_status_id' => $request->operational_status_id,
            'registration_status_id' => $request->registration_status_id,
            'license_status_id' => $request->license_status_id,
            'service_type' => $request->service_type,
            'outpatient' => $outpatient,
            'inpatient' => $inpatient,
        ]);
        
        //return original values from request
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $ward_id = $request->ward_id;
        $facility_name =$request->facility_name;
        $geo_codes = $request->geo_codes;
        $facility_type_id = $request->facility_type_id;
        $facility_level_id = $request->facility_level_id;
        $ownership_id = $request->ownership_id;
        $operational_status_id = $request->operational_status_id;
        $registration_status_id = $request->registration_status_id;
        $license_status_id = $request->license_status_id;
        $service_type = $request->service_type;

        
        return view('public.facilities_list',compact('facilities',
        'state_id', 'lga_id', 'facility_type_id','facility_name', 'geo_codes', 'ward_id','facility_level_id', 
        'ownership_id','operational_status_id','registration_status_id', 'license_status_id','service_type'));     
    }

    private function getLabs(Request $request)
    {
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

    }

    //search hospital from top banner search option
    public function searchHospital(Request $request)
    {
      
        $facility_name = $request->facility_name;

        $facilities = DB::table('hospital_details')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->paginate(20);


        $facilities->appends([
            'facility_name'=>$request->facility_name,
        ]);

        return view('public.hospital_search',compact("facilities"));        
    }

 
  

}
