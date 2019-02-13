<?php

namespace App\Http\Controllers;

use App\Exports\HFExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Download;
use Notification;
use App\Notifications\SendDownloadVerificationCode;

class DownloadController extends Controller
{
    public function index (Request $request){
        if (!$request->session()->has('download_verify')){
            return redirect()->route('openRegistrationForm');
        }


        $facilities = DB::table('hospital_details')
             ->select('unique_id','registration_no','start_date','facility_name','state','lga','ward','ownership',
            'facility_level','longitude','latitude','operation_status','registration_status','license_status')
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->paginate(20);

        //set values facility list when no filter

        list($state_id, $lga_id, $facility_type_id,$facility_name, $geo_codes, $ward_id, 
            $facility_level_id , $ownership_id,$operational_status_id,$registration_status_id,
            $license_status_id,$service_type) = [1,1,1,"",0,0,0,0,0,0,0,0];

        
        return view('public.download_list',compact('facilities',
        'state_id', 'lga_id', 'facility_type_id','facility_name', 'geo_codes', 'ward_id','facility_level_id', 
        'ownership_id','operational_status_id','registration_status_id', 'license_status_id','service_type'));  
    }

    
    public function filter(Request $request){
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

  

        $facilities = DB::table('hospital_details')
            ->select('unique_id','registration_no','start_date','facility_name','state','lga','ward','ownership',
            'facility_level','longitude','latitude','operation_status','registration_status','license_status')
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
            ->where('latitude',$cond,$value)
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
            
        
        return view('public.download_list',compact('facilities',
        'state_id', 'lga_id', 'facility_type_id','facility_name', 'geo_codes', 'ward_id','facility_level_id', 
        'ownership_id','operational_status_id','registration_status_id', 'license_status_id','service_type')); 
    
    }

    public function export(Request $request){
        $state_id = $request->state_id2;
        $lga_id = $request->lga_id2;
        $ward_id = $request->ward_id2;
        $facility_name =$request->facility_name2;
        $geo_codes = $request->geo_codes2;
        $facility_level_id = $request->facility_level_id2;
        $ownership_id = $request->ownership_id2;
        $operational_status_id = $request->operational_status_id2;
        $registration_status_id = $request->registration_status_id2;
        $license_status_id = $request->license_status_id2;

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

   
        $facilities = DB::table('hospital_details')
            ->select('unique_id','registration_no','start_date','facility_name','state','lga','ward','ownership',
            'facility_level','longitude','latitude','operation_status','registration_status','license_status')
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
            ->where('latitude',$cond,$value)
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();

      
        $column_header = array("unique_id","reg_number","start_date","facility_name","state","lga","ward","ownership",
            "facility_level","longitude","latitude","operation_status","regulatory_status","license_status");

        return Excel::download(new HFExport( $facilities, $column_header), 'data.xlsx' );
    }

    public function openRegistrationForm(Request $request)
    {
        if ($request->session()->has('download_verify')){
            return redirect()->route('downloadFacilitiesList');
        }

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
            
            $code = $this->generateToken();
       
            $request->session()->put('download_verify',[
                'token'=>$code,
                'expire_at' => Carbon::now()->addMinutes(15),
            ]);
    
            if ($this->sendToken2Email($request->email,$code)) {
                return redirect()->route('getValidateForm');
            }

            session()->flash("alert-danger", "Something went wrong, try again!");  
            return redirect()->route('openRegistrationForm');
    }

    public function getValidationForm(Request $request){
        if (!$request->session()->has('download_verify')){
            return view('public.download_registration');
        }

        return view('public.download_token');
    }
      
    public function generateToken()
    {
        $code = mt_rand(12345678, 98765432);
        return $code;
    }

    public function sendToken2Email($email,$code)
    {
        try {
            Notification::route('mail', $email)
                        ->notify(new SendDownloadVerificationCode($code));
        } catch (\Exception $ex) {
            return false; //un able send code
        }
        return true;
    }

    //validate the token if valid  give download page
    public function validateToken(Request $request){
        $token_expire = 0;
        $token_match = 0;

        //check if token has expired
        if ($request->session()->get('download_verify.expire_at') < Carbon::now() ){
            $token_expire = 1;
        }else{
            $token_expire = 0;
        }

        //check if token matches
        if ($request->token != $request->session()->get('download_verify.token')){
            $token_match = 0;
        }else{
            $token_match = 1;
        }

        if (($token_expire == 0) AND ($token_match == 1)){
            return redirect()->route('downloadFacilitiesList');
        }
        else{
            return back()->withErrors([
                'token' => 'Invalid token',
            ]);
        }

    }

  

    //for admin module
    public function guestDownloadRequests (){
        $downloads = Download::all();
        return view('downloads.index', compact("downloads"));
    }
    

  
}
