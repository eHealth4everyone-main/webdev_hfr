<?php

namespace App\Http\Controllers;

use App\Exports\HFExport;
use Illuminate\Http\Request;
use App\Download;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;

class DownloadController extends Controller
{
    public function index (){
      
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


        $facilities = DB::table('hospital_details')
        ->select('state','lga','unique_id','facility_name','facility_level','ownership')
        ->orderByRaw('state','lga','facility_name')
        ->paginate(20);
      
        $state_id = 0;
        $facility_type_id = 1;

        return view('public.download_facility_list',compact("facilities",'lst_states','lst_facility_types',
        'state_id','facility_type_id')); 
    }
    
    public function filter(Request $request){
        $state_id = $request->state_id;
        $facility_type_id = $request->facility_type_id;
      
        if ($state_id == 0){
            $state_id2 = "";
        }
        else{
            $state_id2 = $state_id;
        }

        if ($facility_type_id==1){

            $facilities = DB::table('hospital_details')
            ->select('state','lga','unique_id','facility_name','facility_level','ownership')
            ->where('state_id','like','%'.$state_id2.'%')
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

            $facilities->appends([
                'state_id'=>$request->state_id,
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
       
      
        return view('public.download_facility_list',compact("facilities",'lst_states','lst_facility_types',
        'state_id','facility_type_id')); 
    
    }

    public function export($type,$state_id,$format){
  
        if ($state_id == 0){
            $state_id = "";
        }

        if ($type == 1){
            $facilities = DB::table('hospital_details')
                            ->select('unique_id','registration_no','start_date','facility_name','state','lga','ward','ownership',
                            'facility_level','longitude','latitude','operation_status','regulatory_status','license_status')
                            ->where('state_id','like','%'.$state_id.'%')
                            ->orderByRaw('state','lga','facility_name')
                            ->get();

            $column_header = array("unique_id","reg_number","start_date","facility_name","state","lga","ward","ownership",
            "facility_level","longitude","latitude","operation_status","regulatory_status","license_status");
        }
     
        if ($format = 'excel'){
            $down_filename = 'list_of_facilities.xlsx';
        }
        if ($format = 'csv'){
            $down_filename = 'list_of_facilities.csv';
        }
     
        return Excel::download(new HFExport( $facilities, $column_header), $down_filename );

    }

    public function openRegistrationForm()
    {
        return view('public.download_registration');
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
            return view('public.download_facility_list', compact("facilities","type","state"));
    }

    public function adminIndex (){
        $downloads = Download::all();
        return view('downloads.index', compact("downloads"));
     
    }
    
}
