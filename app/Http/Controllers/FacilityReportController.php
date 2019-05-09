<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Exports\HFExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use DateTime;

class FacilityReportController extends Controller
{
    public function updateSelection()
    {
        $facilities="none";
        
        $data['from'] = "";
        $data['to'] = "";
        $data['report'] ="";

        return view('reports.facility_list_updates',compact('facilities','data'));    
    }


    public function getUpdatesReport(Request $request)
    {
        $from = date('Y-m-d', strtotime(str_replace('-', '/', $request->from_date)));
        $to = date('Y-m-d', strtotime(str_replace('-', '/', $request->to_date)));
        $to_date = new DateTime($to);
        $to_date->modify('+1 day');
      
       //New Facilities
        if ($request->report == 1){
            $facilities = DB::table('hospital_details')
            ->select('unique_id','registration_no','start_date','facility_name','alt_facility_name','state','lga','ward','ownership',
            'facility_level','longitude','latitude','operation_status','registration_status','license_status','created_at')
            ->whereBetween('created_at', [$from, $to_date])
            ->Where('state_id', 'like', '%' .  Auth::user()->state_id . '%')
            ->orderBy('created_at')
            ->get();   
            
            $message=$facilities->count()." New facilities were created between ".date('d M Y', strtotime($from)) . " and ". date('d M Y', strtotime($to));  
        }

        //Updated Facilities
        if ($request->report == 2){
            $facilities = DB::table('hospital_details')
            ->select('unique_id','registration_no','start_date','facility_name','alt_facility_name','state','lga','ward','ownership',
            'facility_level','longitude','latitude','operation_status','registration_status','license_status','updated_at')
            ->whereBetween('updated_at', [$from, $to_date])
            ->Where('state_id', 'like', '%' .  Auth::user()->state_id . '%')
            ->orderBy('updated_at')
            ->get();   
            
            $message=$facilities->count()." Facilities were updated between ".date('d M Y', strtotime($from)) . " and ". date('d M Y', strtotime($to));    
        }

        //Deleted Facilities
        if ($request->report == 3){
            $facilities = DB::table('hospital_details_history')
            ->select('unique_id','registration_no','start_date','facility_name','alt_facility_name','state','lga','ward','ownership',
            'facility_level','longitude','latitude','operation_status','registration_status','license_status','updated_at')
            ->whereBetween('updated_at', [$from, $to_date])
            ->Where('state_id', 'like', '%' .  Auth::user()->state_id . '%')
            ->where('status_id',20)
            ->orderBy('updated_at')
            ->get();      
          
            $message=$facilities->count()." Facilities were deleted between ".date('d M Y', strtotime($from)) . " and ". date('d M Y', strtotime($to));    
        }
    
        Cache::put('facilities_updates_download', $facilities, 60);

        $data['from'] = $request->from_date;
        $data['to'] = $request->to_date;
        $data['report'] = $request->report;
        $data['message'] = $message;  
        
        return view('reports.facility_list_updates',compact('facilities','data'));     
    }

    public function updatesDownload(){

        if (Cache::has('facilities_updates_download')) {
            $facilities = Cache::get('facilities_updates_download');


            $column_header = array("unique_id","reg_number","start_date","facility_name","alt_facility_name","state","lga","ward","ownership",
            "facility_level","longitude","latitude","operation_status","registration_status","license_status","date");
            
            return Excel::download(new HFExport( $facilities->all(), $column_header), "data.xlsx");
        }        
    }

    public function servicesIndex()
    {
        $facilities = DB::table('hospital_offered_services')
            ->select('unique_id','facility_name','state','lga','ward','ownership','facility_level',
            'beds', 'outpatient','inpatient','onsite_laboratory','onsite_imaging','onsite_pharmarcy','mortuary_services',
            'ambulance_services','services')
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('ward')
            ->orderBy('facility_name')
            ->get(); 
        
        Cache::put('facilities_services_download', $facilities, 60);

            $data['state_id'] = 1;
            $data['lga_id'] = 0;
            $data['ward_id'] = 0;
            $data['facility_level_id'] = 0;
            $data['ownership_id'] = 0;

        return view('reports.facility_services',compact('facilities','data'));    
    }

    public function getServicesReport(Request $request)
    {
        $facilities = DB::table('hospital_offered_services')
        ->select('unique_id','facility_name','state','lga','ward','ownership','facility_level',
        'beds', 'outpatient','inpatient','onsite_laboratory','onsite_imaging','onsite_pharmarcy','mortuary_services',
        'ambulance_services','services')
        ->where('state_id','like','%'.$request->state_id.'%')
        ->where('lga_id','like','%'.$request->lga_id.'%')
        ->where(DB::Raw("IFNULL(ward_id, '')"),'like','%'.$request->ward_id.'%')
        ->where('facility_level_id','like','%'.$request->facility_level_id.'%')
        ->where('ownership_id','like','%'.$request->ownership_id.'%')
        ->get();   

        Cache::put('facilities_services_download', $facilities, 60);

        $data['state_id'] = $request->state_id;
        $data['lga_id'] = $request->lga_id;
        $data['ward_id'] = $request->ward_id;
        $data['facility_level_id'] = $request->facility_level_id;
        $data['ownership_id'] = $request->ownership_id;

        return view('reports.facility_services',compact('facilities','data'));     
    }
  
    public function servicesDownload(){

        if (Cache::has('facilities_services_download')) {
            $facilities = Cache::get('facilities_services_download');

            $column_header = array("Facility_id","facility_name","state","lga","ward","ownership","facility_level",
            "number_of_beds", "outpatient_services","inpatient_services","onsite_laboratory","onsite_imaging","onsite_pharmarcy","mortuary_services",
            "ambulance_services","service_rendered");
            
            return Excel::download(new HFExport( $facilities->all(), $column_header), "data.xlsx");
        }        
    }

    public function statusIndex()
    {
        $facility_status = DB::table('facility_status_state_pivot')->get(); 
 
        $data['state_id'] = 1;

        return view('reports.facility_status',compact('facility_status','data'));    
    }

    public function getStatusReport(Request $request)
    {
        if ($request->state_id ==1){
            $facility_status = DB::table('facility_status_state_pivot')
                ->get(); 
        }
        else{
            $facility_status = DB::table('facility_status_lga_pivot')
            ->where('state_id','like','%'.$request->state_id.'%')
            ->get(); 
        }
        
        $data['state_id'] = $request->state_id;

        return view('reports.facility_status',compact('facility_status','data'));     
    }

    public function statusDownload(Request $request){

      if ($request->state_id ==1){
        $facility_status = DB::table('facility_status_state_pivot')
            ->select('state','New_Facility_Requested','Update_Requested','Deletion_Requested','Request_Verified','Request_Validated','Facility_Created',
            'Facility_Updated','Facility_Deleted','Verification_Rejected','Validation_Rejected','Publishing_Rejected')
            ->get();

        $column_header = array('lga','New Facility Requested','Update Requested','Deletion Requested','Request Verified','Request Validated','Facility Created',
        'Facility Updated','Facility Deleted','Verification Rejected','Validation Rejected','Publishing Rejected');
      }
      else{
        $facility_status = DB::table('facility_status_lga_pivot')
            ->select('lga','New_Facility_Requested','Update_Requested','Deletion_Requested','Request_Verified','Request_Validated','Facility_Created',
            'Facility_Updated','Facility_Deleted','Verification_Rejected','Validation_Rejected','Publishing_Rejected')
            ->where('state_id','like','%'.$request->state_id.'%')
            ->get();
        
        $column_header = array('lga','New Facility Requested','Update Requested','Deletion Requested','Request Verified','Request Validated','Facility Created',
        'Facility Updated','Facility Deleted','Verification Rejected','Validation Rejected','Publishing Rejected');
      }
            
        return Excel::download(new HFExport( $facility_status, $column_header), "data.xlsx");
              
    }

   
}
