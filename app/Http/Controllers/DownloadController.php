<?php

namespace App\Http\Controllers;

use App\Exports\HFExport;
use Illuminate\Http\Request;
use App\Download;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DownloadController extends Controller
{
    public function index (){
        $state = '0';
        $type = '1';

        $facilities = DB::table('hospitals_details')->get();
        return view('public.download_export', compact("facilities","type","state"));
    }
    
    public function getFacilities(Request $request){
        $type = 0;
        $state = $request->stateid;
        $condition = '';

        if ($state == 0){
            $condition = '<>';
        }
        else{
            $condition = '=';
        }
      

        if ($request->facilitytype==1){
            $facilities = DB::table('hospitals_details')
                            ->where('state_id', $condition, $state)
                            ->get();
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

        return view('public.download_export', compact("facilities","type","state"));
    }

    public function export($type,$state,$format){
        $condition = '';

        if ($state == 0){
            $condition = '<>';
        }
        else{
            $condition = '=';
        }

        if ($type == 1){
            $facilities = DB::table('hospitals_details')
                            ->where('state_id', $condition, $state)
                            ->get();

            $column_header = array("id","unique_id","reg_number","facility_name","alt_facility_name","state_id","state","state_code",
            "lga_id","lga","level","ownership","ownership_type","ownership_details","comm_date","ward",
            "house_no","street_name","longitude","latitude","postal_address","phone_number","email_address",
            "website","operational_days","operational_hours","op_status_id","op_status","reg_status_id",
            "reg_status","lic_status_id","lic_status","IPD","OPD");

        }

      
     
        if ($format = 'excel'){
            $down_filename = 'list_of_facilities.xlsx';
        }
        if ($format = 'csv'){
            $down_filename = 'list_of_facilities.csv';
        }
     
        return Excel::download(new HFExport( $facilities, $column_header), $down_filename );

    }

    public function DownloadForm()
    {
     
        return view('public.download');
    }

    public function store(Request $request)
        {
            $request->validate([
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
                'organisation' => 'nullable|string|max:100',
                'country' => 'required',
                'designation' => 'required',
                'country' => 'required',
                'purpose' => 'required|max:200',
                'email' => 'required|string|email|max:100',
                'g-recaptcha-response' => 'required|captcha',
            ]);

            Download::create($request->all());

            session()->flash("alert-success", "Successfull! Download the data");
            
        
            $state = '0';
            $type = '1';
    
            $facilities = DB::table('hospitals_details')->get();
            return view('public.download_export', compact("facilities","type","state"));
    }

    public function adminIndex (){
        $downloads = Download::all();
        return view('downloads.index', compact("downloads"));
     
    }
    
}
