<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use App\Exports\HFExport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;


class FacilityStatusReportController extends Controller
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

       //New Facilities
        if ($request->report == 1){
            $facilities = DB::table('hospital_details')
            ->select('unique_id','registration_no','start_date','facility_name','alt_facility_name','state','lga','ward','ownership',
            'facility_level','longitude','latitude','operation_status','registration_status','license_status','created_at')
            ->whereBetween('created_at', [$from, $to])
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
            ->whereBetween('updated_at', [$from, $to])
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
            ->whereBetween('updated_at', [$from, $to])
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

  
   
}
