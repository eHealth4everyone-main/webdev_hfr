<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Exports\HFExport;
use Maatwebsite\Excel\Facades\Excel;
use App\hs_hospital;
use App\hs_hospital_history;
use App\hs_hospital_service_history;
use App\hs_status_tracking;
use Carbon\Carbon;
use Auth;
use App\Notifications\CreateRequest;
use App\Notifications\UpdateRequest;
use App\Notifications\DeleteRequest;
use App\User;


class HospitalsController extends Controller
{
  
    public function index()
    {
        $facilities = DB::table('hospital_details')
            ->Where('state_id', 'like', '%' .  Auth::user()->state_id . '%')
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->paginate(20);
            
            list($state_id, $lga_id,$facility_name, $geo_codes, $ward_id, 
            $facility_level_id , $ownership_id,$operational_status_id,$registration_status_id,
            $license_status_id) = [1,1,"",0,0,0,0,0,0,0,0];
            
            return view('hospitals.index',compact('facilities',
            'state_id', 'lga_id','facility_name', 'geo_codes', 'ward_id','facility_level_id', 
            'ownership_id','operational_status_id','registration_status_id', 'license_status_id'));  
    }
       
  
    public function create()
    {
        //get hospital services
        $lst_services = DB::table('lst_hosp_services')
                    ->get();
        
        return view('hospitals.create',compact('lst_services')); 
    }
    
    public function store(Request $request)
    {
       
        $request->validate([
            'registration_no'=>'nullable|max:20',
            'start_date'=>'nullable|date',
            'facility_name'=>'required|max:200',
            'alt_facility_name'=>'nullable|max:200',
            'state_id'=>'required',
            'lga_id'=>'required',
            'ward_id'=>'required',
            'state_unique_id' => 'nullable|max:50',
            'ownership_id'=>'required',
            'ownership_type_id'=>'required',
            'facility_level_id'=>'required',
            'facility_level_option_id'=>'nullable',
            'longitude'=>'nullable',
            'latitude'=>'nullable',
            'physical_location'=>'nullable|max:100',
            'postal_address'=>'nullable|max:100',
            'phone_number'=>'nullable|max:20',
            'alternate_number'=>'nullable|max:20',
            'email_address'=>'nullable|email',
            'website'=>'nullable|max:100|url',
            'operational_days'=>'nullable',
            'operational_hours'=>'nullable',
            'operational_status_id'=>'required',
            'registration_status_id'=>'nullable',
            'license_status_id'=>'nullable',
            'doctors'=>'nullable|numeric',
            'dentist'=>'nullable|numeric',
            'pharmacists'=>'nullable|numeric',
            'pharmacy_technicians'=>'nullable|numeric',
            'nurses'=>'nullable|numeric',
            'lab_scientists'=>'nullable|numeric',
            'midwifes'=>'nullable|numeric',
            'lab_technicians'=>'nullable|numeric',
            'nurse_midwife'=>'nullable|numeric',
            'him_officers'=>'nullable|numeric',
            'community_health_officer'=>'nullable|numeric',
            'community_extension_workers'=>'nullable|numeric',
            'jun_community_extension_worker'=>'nullable|numeric',
            'attendants'=>'nullable|numeric',
            'dental_technicians'=>'nullable|numeric',
            'env_health_officers'=>'nullable|numeric',
            'onsite_laboratory'=>'nullable',
            'onsite_imaging'=>'nullable',
            'onsite_pharmarcy'=>'nullable',
            'mortuary_services'=>'nullable',
            'ambulance'=>'nullable',
            'beds'=>'nullable|numeric',
            'outpatient'=>'nullable',
            'inpatient'=>'nullable',
        ]);
        
        $start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date)));
     
        $hosp = new hs_hospital_history;
        $hosp->fill($request->all());
        $hosp->unique_id = $hosp->generateUniqueID($request->lga_id,'1',$request->facility_level_id,$request->ownership_id);
        $hosp->start_date = $start_date;
        $hosp->requested_at = Carbon::now()->format('Y-m-d H:i:s');
        $hosp->status_id = 1;
        $hosp->created_by = Auth::user()->id;
        $hosp->requested_by = Auth::user()->id;
        $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
       
        $services = $request->services;
        
       

        DB::beginTransaction();
        try {
            $hosp->save();
            //get id of inserted record
            $hosp_id = $hosp->id;
            
            //insert in status tracking table
            $status = new hs_status_tracking;
            $status->hospital_id = $hosp_id;
            $status->user_id = Auth::user()->id;
            $status->status_id = 1;
            $status->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $status->save();

            //insert services
            if (!empty($services)){
                    foreach ($services as $id){
                        $hosp_services = new hs_hospital_service_history;
                        $hosp_services->service_id = $id;
                        $hosp_services->hospital_id = $hosp_id; 
                        $hosp_services->save();
                    }            
            }
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

         //****** send notifications *********

         //get users with approval access
        // $users = DB::select("SELECT u.id FROM users u
        //         JOIN model_has_roles r on r.model_id = u.id
        //         JOIN role_has_permissions p on p.role_id = r.role_id
        //         WHERE p.permission_id = 59 and u.state_id = ". $request->state_id ."");
        
        // foreach ($users as $user){
        //     $user = user::find($user->id);
        //     $user->notify(new CreateRequest($request->facility_name, $hosp_id));
        // }  
        // ****** notifiction end*****
     
        
        session()->flash("alert-success", "Request Sent Successfully!");
        return redirect()->back();
    }
    
    
    
    public function edit($id)
    {
            $hosp =hs_hospital::findorfail($id);

            $services = DB::table('hs_hospital_services')
                    ->select('service_id')
                    ->where('hospital_id','=',$id)
                    ->get();

            $current_services = [];
            foreach ($services as $s) {
                $current_services[] = $s->service_id;
            }
           
             //get hospital services
            $lst_services = DB::table('lst_hosp_services')->get();
           
            return view('hospitals.edit',compact('hosp','current_services','lst_services')); 
    }
    
  
    public function update(Request $request, $id)
    {
        $request->validate([
            'registration_no'=>'nullable|max:20',
            'start_date'=>'nullable|date',
            'facility_name'=>'required|max:200',
            'alt_facility_name'=>'nullable|max:200',
            'state_id'=>'required',
            'lga_id'=>'required',
            'ward_id'=>'required',
            'state_unique_id' => 'nullable|max:50',
            'ownership_id'=>'required',
            'ownership_type_id'=>'required',
            'facility_level_id'=>'required',
            'facility_level_option_id'=>'nullable',
            'longitude'=>'nullable',
            'latitude'=>'nullable',
            'physical_location'=>'nullable|max:100',
            'postal_address'=>'nullable|max:100',
            'phone_number'=>'nullable|max:20',
            'alternate_number'=>'nullable|max:20',
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'operational_hours'=>'nullable',
            'operational_status_id'=>'required',
            'registration_status_id'=>'nullable',
            'license_status_id'=>'nullable',
            'doctors'=>'nullable|numeric',
            'pharmacists'=>'nullable|numeric',
            'pharmacy_technicians'=>'nullable|numeric',
            'nurses'=>'nullable|numeric',
            'lab_scientists'=>'nullable|numeric',
            'midwifes'=>'nullable|numeric',
            'lab_technicians'=>'nullable|numeric',
            'nurse_midwife'=>'nullable|numeric',
            'him_officers'=>'nullable|numeric',
            'community_health_officer'=>'nullable|numeric',
            'community_extension_workers'=>'nullable|numeric',
            'jun_community_extension_worker'=>'nullable|numeric',
            'attendants'=>'nullable|numeric',
            'dental_technicians'=>'nullable|numeric',
            'env_health_officers'=>'nullable|numeric',
            'onsite_laboratory'=>'nullable',
            'onsite_imaging'=>'nullable',
            'onsite_pharmarcy'=>'nullable',
            'mortuary_services'=>'nullable',
            'ambulance'=>'nullable',
            'beds'=>'nullable|numeric',
            'outpatient'=>'nullable',
            'inpatient'=>'nullable',
        ]);
        
        //update records in history with new changes
        $hosp = new hs_hospital_history;
        $hosp = hs_hospital_history::findOrFail($id);
        $hosp->fill($request->all());
        $hosp->status_id = 8;
        $hosp->requested_by = Auth::user()->id;
        $hosp->requested_at = Carbon::now()->format('Y-m-d H:i:s');  
        $hosp->request_note = '';
        $hosp->verified_by= $request->null;
        $hosp->verified_at= $request->null;
        $hosp->verify_note = $request->null;
        $hosp->validated_by = $request->null;
        $hosp->validated_at = $request->null;
        $hosp->validate_note = $request->null;
        $hosp->published_by = $request->null;
        $hosp->published_at = $request->null;
        $hosp->publish_note = $request->null; 
        $hosp->start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date))); 
        $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
        
        //insert in status tracking
        $status = new hs_status_tracking;
        $status->hospital_id = $id;
        $status->user_id = Auth::user()->id;
        $status->status_id = 8;
        $status->created_at = Carbon::now()->format('Y-m-d H:i:s');

        //get services before update
        $services = DB::table('hs_hospital_services')
                ->select('service_id')
                ->where('hospital_id','=',$id)
                ->get();

        $services_before = [];
        foreach ($services as $s) {
            $services_before[] = $s->service_id;
        }

        if(empty($request->services)){
            $services_update = [];
        }
        else{
            $services_update = $request->services;
        }

        

        DB::beginTransaction();
        try {
            $hosp->save();
            $status->save();

             //update hospital services history if services are updated
            $services_equal = $hosp->array_equal($services_before, $services_update);

            if(!$services_equal){ 
                hs_hospital_service_history::where('hospital_id', $id)->delete();

                if (!empty($services_update)){
                    foreach ($services_update as $service_id){
                        $hosp_services = new hs_hospital_service_history;
                        $hosp_services->service_id = $service_id;
                        $hosp_services->hospital_id = $id; 
                        $hosp_services->save();
                    }         
                }
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
       
        

        //****** send notifications *********

        //get users with approval access
        // $users = DB::select("SELECT u.id FROM users u
        //         JOIN model_has_roles r on r.model_id = u.id
        //         JOIN role_has_permissions p on p.role_id = r.role_id
        //         WHERE p.permission_id = 59 and u.state_id = ". $request->state_id ."");
        
        // foreach ($users as $user){
        //     $user = user::find($user->id);
        //     $user->notify(new UpdateRequest($request->facility_name, $id));
        // }  
        // ****** notifiction end*****

        session()->flash("alert-success", "Request Sent Successfully!");
        return redirect()->route('hospitals.index');
    }
    
    public function InitiateDelete(Request $request){ 
        $hs_tracking = new hs_status_tracking;
        $hs_tracking->hospital_id = $request->facility_id;
        $hs_tracking->user_id = Auth::user()->id;
        $hs_tracking->status_id = '15';
        $hs_tracking->note = $request->reason;
        $hs_tracking->created_at = Carbon::now()->format('Y-m-d H:i:s');
       
        $hosp = new hs_hospital_history;
        $hosp = hs_hospital_history::findOrFail($request->facility_id); 
        $hosp->status_id = '15';
        $hosp->requested_at = Carbon::now()->format('Y-m-d H:i:s');
        $hosp->requested_by = Auth::user()->id; 
        $hosp->request_note = $request->reason;
        $hosp->verified_by= $request->null;
        $hosp->verified_at= $request->null;
        $hosp->verify_note = $request->null;
        $hosp->validated_by = $request->null;
        $hosp->validated_at = $request->null;
        $hosp->validate_note = $request->null;
        $hosp->published_by = $request->null;
        $hosp->published_at = $request->null;
        $hosp->publish_note = $request->null;
       
        DB::beginTransaction();
        try {
            hs_hospital_history::disableAuditing();  
            $hs_tracking->save();
            $hosp->save();
            hs_hospital_history::enableAuditing();        
            
                DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }
       
        
        //****** send notifications *********

        //get users with approval access
        // $users = DB::select("SELECT u.id FROM users u
        //     JOIN model_has_roles r on r.model_id = u.id
        //     JOIN role_has_permissions p on p.role_id = r.role_id
        //     WHERE p.permission_id = 59 and u.state_id = ". $request->state_id_del ."");
            
        // $name = $request->facility_name_to_del;
        // foreach ($users as $user){
        //     $user = user::find($user->id);
        //     $user->notify(new DeleteRequest($name, $request->facility_id));
        // }  
        // ****** notifiction end*****


        session()->flash("alert-success", "Delete request initiated successfully!");
        return redirect()->route('hospitals.index');
    }

 
    public function search(Request $request)
    {
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $ward_id = $request->ward_id;
        $facility_name =$request->facility_name;
        $geo_codes = $request->geo_codes;
        $facility_level_id = $request->facility_level_id;
        $ownership_id = $request->ownership_id;
        $operational_status_id = $request->operational_status_id;
        $registration_status_id = $request->registration_status_id;
        $license_status_id = $request->license_status_id;
    
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
            ->where('state_id','like','%'.$state_id.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->where(DB::Raw("IFNULL(ward_id, '')"),'like','%'.$ward_id.'%')
            ->where('facility_level_id','like','%'.$facility_level_id.'%')
            ->where('ownership_id','like','%'.$ownership_id.'%')
            ->where('operational_status_id','like','%'.$operational_status_id.'%')
            ->where('registration_status_id','like','%'.$registration_status_id.'%')
            ->where('license_status_id','like','%'.$license_status_id.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
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
            'facility_level_id' => $request->facility_level_id,
            'ownership_id' => $request->ownership_id,
            'operational_status_id' => $request->operational_status_id,
            'registration_status_id' => $request->registration_status_id,
            'license_status_id' => $request->license_status_id,
        ]);
        
        //return original values from request
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $ward_id = $request->ward_id;
        $facility_name =$request->facility_name;
        $geo_codes = $request->geo_codes;
        $facility_level_id = $request->facility_level_id;
        $ownership_id = $request->ownership_id;
        $operational_status_id = $request->operational_status_id;
        $registration_status_id = $request->registration_status_id;
        $license_status_id = $request->license_status_id;

        
        return view('hospitals.index',compact('facilities',
        'state_id', 'lga_id','facility_name', 'geo_codes', 'ward_id','facility_level_id', 
        'ownership_id','operational_status_id','registration_status_id', 'license_status_id'));    
    }

    public function getServices(Request $request)
    {
        $services = DB::select("select s.service_category_id category_id,s.name from hs_hospital_services hs
            join lst_hosp_services s on hs.service_id=s.id
            where hospital_id='".$request->hosp_id."'");

      return $services;
    }

    public function getServicesHistory(Request $request)
    {
        $services = DB::select("select s.service_category_id category_id,s.name from hs_hospital_services_history hs
            join lst_hosp_services s on hs.service_id=s.id
            where hospital_id='".$request->hosp_id."'");

      return $services;
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
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->where('latitude',$cond,$value)
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->get();


        $column_header = array("unique_id","reg_number","start_date","facility_name","state","lga","ward","ownership",
        "facility_level","longitude","latitude","operation_status","registration_status","license_status");
        
    
        if ($request->format == 'xls'){
            $down_filename = 'data.xlsx';
        }
        if ($request->format == 'csv'){
            $down_filename = 'data.csv';
        }
     
        return Excel::download(new HFExport( $facilities, $column_header), $down_filename );

    }



}
