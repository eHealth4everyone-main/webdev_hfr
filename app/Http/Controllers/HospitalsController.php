<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

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
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);
            
        //get state list
        $lst_states = Cache::remember('lst_states', 60, function () {
        return DB::table('ou_states')
                ->select('id','name')
                ->orderByRaw('name ASC')
                ->get();
        });
        return view('hospitals.index',compact('facilities','lst_states')); 
    }
       
  
    public function create()
    {
        //get state list
        $lst_states = Cache::remember('lst_states', 60, function () {
        return DB::table('ou_states')
                ->select('id','name')
                ->orderByRaw('name ASC')
                ->get();
        });

        //get facility types
        $lst_level_of_care = Cache::remember('lst_level_of_care', 60, function () {
            return DB::table('lst_level_of_care')
                    ->select('id','name')
                    ->get();
        });
        //get ownership
        $lst_ownerships= Cache::remember('lst_ownerships', 60, function () {
            return DB::table('lst_ownerships')
                    ->select('id','name')
                    ->get();
        });
        //get opertion statuss
        $lst_oparational_status= Cache::remember('lst_oparational_status', 60, function () {
            return DB::table('lst_oparational_status')
                    ->select('id','status')
                    ->where('category','1')
                    ->get();
        });
            //get regulatory statuss
            $lst_regulatory_status= Cache::remember('lst_regulatory_status', 60, function () {
            return DB::table('lst_regulatory_status')
                    ->select('id','status')
                    ->get();
        });
        //get license statuss
        $lst_license_status= Cache::remember('lst_license_status', 60, function () {
            return DB::table('lst_license_status')
                    ->select('id','status')
                    ->get();
        });
        //get hospital services
        $lst_services = DB::table('lst_hosp_services')
                    ->get();
        
        return view('hospitals.create',compact('lst_level_of_care','lst_states','lst_ownerships','lst_oparational_status',
        'lst_regulatory_status','lst_license_status','lst_services')); 
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
            'ownership_id'=>'required',
            'ownership_type_id'=>'required',
            'ownership_details'=>'nullable',
            'facility_level_id'=>'required',
            'facility_level_option_id'=>'nullable',
            'house_no'=>'nullable',
            'street_name'=>'nullable',
            'longitude'=>'nullable',
            'latitude'=>'nullable',
            'postal_address'=>'nullable',
            'phone_number'=>'nullable',
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'operational_hours'=>'nullable',
            'operational_status_id'=>'required',
            'regulatory_status_id'=>'nullable',
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
            'dental_technicians'=>'nullable|numeric',
            'env_health_officers'=>'nullable|numeric',
            'beds_accidents_emerg'=>'nullable|numeric',
            'beds_adminission'=>'nullable|numeric',
            'beds_icu'=>'nullable|numeric',
            'onsite_laboratory'=>'nullable',
            'onsite_imaging'=>'nullable',
            'onsite_pharmarcy'=>'nullable',
            'mortuary_services'=>'nullable',
            'beds_accidents_emerg'=>'nullable|numeric',
            'beds_adminission'=>'nullable|numeric',
            'beds_icu'=>'nullable|numeric',
            'onsite_pharmarcy'=>'nullable',
            'onsite_laboratory'=>'nullable',
            'onsite_imaging'=>'nullable',
            'mortuary_services'=>'nullable',
        ]);
        
        $start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date)));
     
        $hosp = new hs_hospital_history;
        $hosp->fill($request->all());
        $hosp->unique_id = $hosp->generateUniqueID($request->lga_id,'1',$request->facility_level_id,$request->ownership_id);
        $hosp->start_date = $start_date;
        $hosp->status_id = 1;
        $hosp->created_by = Auth::user()->id;
        $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
        $hosp->save();
        
        //get id of inserted record
        $hosp_id = $hosp->id;
        
         //insert services
         $services[] = $request->services;
         if (!empty($services)){
            foreach ($services as $id){
                $hosp_services = new hs_hospital_service_history;
                $hosp_services->service_id = $id;
                $hosp_services->hospital_id = $hosp_id; 
                $hosp_services->save();
            }            
         }
        
         //****** send notifications *********

         //get users with approval access
        $users = DB::select("SELECT u.id FROM users u
                JOIN model_has_roles r on r.model_id = u.id
                JOIN role_has_permissions p on p.role_id = r.role_id
                WHERE p.permission_id = 59 and u.state_id = ". $request->state_id ."");
        
        foreach ($users as $user){
            $user = user::find($user->id);
            $user->notify(new CreateRequest($request->facility_name, $hosp_id));
        }  
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
                 
            //get state list
            $lst_states = Cache::remember('lst_states', 60, function () {
            return DB::table('ou_states')
                    ->select('id','name')
                    ->orderByRaw('name ASC')
                    ->get();
            });

            //get facility types
            $lst_level_of_care = Cache::remember('lst_level_of_care', 60, function () {
                return DB::table('lst_level_of_care')
                        ->select('id','name')
                        ->get();
            });
            //get ownership
            $lst_ownerships= Cache::remember('lst_ownerships', 60, function () {
                return DB::table('lst_ownerships')
                        ->select('id','name')
                        ->get();
            });
            //get opertion statuss
            $lst_oparational_status= Cache::remember('lst_oparational_status', 60, function () {
                return DB::table('lst_oparational_status')
                        ->select('id','status')
                        ->where('category','1')
                        ->get();
            });
            //get regulatory statuss
            $lst_regulatory_status= Cache::remember('lst_regulatory_status', 60, function () {
                return DB::table('lst_regulatory_status')
                        ->select('id','status')
                        ->get();
            });
            //get license statuss
            $lst_license_status= Cache::remember('lst_license_status', 60, function () {
                return DB::table('lst_license_status')
                        ->select('id','status')
                        ->get();
            });

             //get hospital services
            $lst_services = DB::table('lst_hosp_services')->get();

            //get status to check if the facility is being updated
            $update_status = DB::table('hospital_status_tracking')
                ->select('status_id')
                ->where('hospital_id',$id)   
                ->where('action_type','UPDATE')     
                ->orderBy('created_at', 'DESC')
                ->first();

            if(is_null($update_status)){
                $updating=FALSE;
            }
            else{
                if($update_status->status_id == 13){
                    $updating=FALSE;
                }else{
                    $updating=TRUE;
                }
            }
           
            return view('hospitals.edit',compact('hosp','current_services','lst_level_of_care','lst_states','lst_ownerships','lst_oparational_status',
            'lst_regulatory_status','lst_license_status','lst_services','updating')); 
    }
    
  
    public function update(Request $request, $id)
    {
        $request->validate([
            'registration_no'=>'nullable',
            'start_date'=>'nullable|date',
            'facility_name'=>'required|max:200',
            'alt_facility_name'=>'nullable|max:200',
            'state_id'=>'required',
            'lga_id'=>'required',
            'ward_id'=>'required',
            'ownership_id'=>'required',
            'ownership_type_id'=>'required',
            'ownership_details'=>'nullable',
            'facility_level_id'=>'required',
            'facility_level_option_id'=>'nullable',
            'house_no'=>'nullable',
            'street_name'=>'nullable',
            'longitude'=>'nullable',
            'latitude'=>'nullable',
            'postal_address'=>'nullable',
            'phone_number'=>'nullable',
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'operational_hours'=>'nullable',
            'operational_status_id'=>'required',
            'regulatory_status_id'=>'nullable',
            'license_status_id'=>'nullable',
            'doctors'=>'nullable|numeric',
            'pharmacists'=>'nullable',
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
            'dental_technicians'=>'nullable|numeric',
            'env_health_officers'=>'nullable|numeric',
            'beds_accidents_emerg'=>'nullable|numeric',
            'beds_adminission'=>'nullable|numeric',
            'beds_icu'=>'nullable|numeric',
            'onsite_laboratory'=>'nullable',
            'onsite_imaging'=>'nullable',
            'onsite_pharmarcy'=>'nullable',
            'mortuary_services'=>'nullable',
            'beds_accidents_emerg'=>'nullable|numeric',
            'beds_adminission'=>'nullable|numeric',
            'beds_icu'=>'nullable|numeric',
            'onsite_pharmarcy'=>'nullable',
            'onsite_laboratory'=>'nullable',
            'onsite_imaging'=>'nullable',
            'mortuary_services'=>'nullable',
        ]);

        //update records in history with new changes
        $hosp = new hs_hospital_history;
        
        $update_no = $hosp->getUpdateNumber($id);
    
        $hosp = hs_hospital_history::findOrFail($id);
        $hosp->fill($request->all());
        $hosp->status_id = 8;
        $hosp->requested_by = Auth::user()->id;
        $hosp->update_no = $update_no;
        $hosp->start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date))); 
        $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
        $hosp->save();
        
        //insert in status tracking
        $status = new hs_status_tracking;
        $status->hospital_id = $id;
        $status->action = 'Update Request';
        $status->user_id = Auth::user()->id;
        $status->status_id = 8;
        $status->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $status->update_no = $update_no;
        $status->save();

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

        $diff = array_diff($services_before, $services_update);

        //update hospital services
        $deleted = DB::delete("delete from hs_hospital_services_history where hospital_id ='".$id."' and id > 0");
                
        if(!empty($services_update) and count($diff) > 0){ //if diff > 0 services are updated 
            foreach ($services_update as $service_id){
                $hosp_services = new hs_hospital_service_history;
                $hosp_services->service_id = $service_id;
                $hosp_services->hospital_id = $id; 
                $hosp_services->save();
            }
        }

        //****** send notifications *********

        //get users with approval access
        $users = DB::select("SELECT u.id FROM users u
                JOIN model_has_roles r on r.model_id = u.id
                JOIN role_has_permissions p on p.role_id = r.role_id
                WHERE p.permission_id = 59 and u.state_id = ". $request->state_id ."");
        
        foreach ($users as $user){
            $user = user::find($user->id);
            $user->notify(new UpdateRequest($request->facility_name, $id));
        }  
        // ****** notifiction end*****

        session()->flash("alert-success", "Request Sent Successfully!");
        return redirect()->route('hospitals.index');
    }
    
    public function InitiateDelete(Request $request){ 
        
        $hs_tracking = new hs_status_tracking;
        $hs_tracking->action = "Delete Request"; 
        $hs_tracking->hospital_id = $request->facility_id;
        $hs_tracking->user_id = Auth::user()->id;
        $hs_tracking->status_id = '15';
        $hs_tracking->note = $request->reason;
        $hs_tracking->save();

        $hosp = new hs_hospital_history;
        $hosp = hs_hospital_history::findOrFail($request->facility_id); 
        $hosp->status_id = '15';
        $hosp->created_at = Carbon::now()->format('Y-m-d H:i:s');
        $hosp->requested_by = Auth::user()->id; 
        $hosp->save();
        
        
        //****** send notifications *********

        //get users with approval access
        $users = DB::select("SELECT u.id FROM users u
            JOIN model_has_roles r on r.model_id = u.id
            JOIN role_has_permissions p on p.role_id = r.role_id
            WHERE p.permission_id = 59 and u.state_id = ". $request->state_id_del ."");
            
        $name = $request->facility_name_to_del;
        foreach ($users as $user){
            $user = user::find($user->id);
            $user->notify(new DeleteRequest($name, $request->facility_id));
        }  
        // ****** notifiction end*****


        session()->flash("alert-success", "Delete request initiated successfully!");
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $facility_name = $request->facility_name;

         $facilities = DB::table('hospital_details')
            ->where('state_id','like','%'.$state_id.'%')
            ->where('lga_id','like','%'.$lga_id.'%')
            ->Where('facility_name', 'like', '%' .  $facility_name . '%')
            ->Where('state_id', 'like', '%' .  Auth::user()->state_id . '%')
            ->orderByRaw('state','lga','facility_name')
            ->paginate(20);

        $facilities->appends([
            'state_id'=>$request->state_id,
            'lga_id'=>$request->lga_id,
            'facility_name'=>$request->facility_name,
        ]);

        //get state list
        $lst_states = Cache::remember('lst_states', 60, function () {
            return DB::table('ou_states')
                    ->select('id','name')
                    ->orderByRaw('name ASC')
                    ->get();
        });
      
        return view('hospitals.index',compact('facilities','lst_states','state_id','facility_name'));       
    }

    public function getServices(Request $request)
    {
        $services = DB::select("select s.service_category_id category_id,s.name from hs_hospital_services hs
            join lst_hosp_services s on hs.service_id=s.id
            where hospital_id='".$request->hosp_id."'");

      return $services;
    }


}
