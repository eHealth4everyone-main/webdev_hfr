<?php

namespace App\Http\Controllers\Approval;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\hs_hospital;
use App\hs_hospital_history;
use App\hs_hospital_service_history;
use App\hs_status_tracking;
use Carbon\Carbon;


class MyRequestController extends Controller
{

    public function myPendingRequest()
    {
        $myrequests = DB::select("SELECT * FROM hospital_details_history WHERE 
        (created_by = ". Auth::user()->id ." OR requested_id = ". Auth::user()->id .") 
        AND status_id NOT IN (6,13,20,5,7,12,14,19,21)");

        return view('approvals.my_pending_requests',compact('myrequests')); 
    }
    
    public function myApprovedRequest()
    {
        $myrequests = DB::select("SELECT * FROM hospital_details_history WHERE 
        (created_by = ". Auth::user()->id ." OR requested_id = ". Auth::user()->id .") 
        AND status_id IN (6,13,20)");

        return view('approvals.my_approved_requests',compact('myrequests')); 
    }

    public function myRejectedRequest()
    {
        $myrequests = DB::select("SELECT * FROM hospital_details_history WHERE 
        (created_by = ". Auth::user()->id ." OR requested_id = ". Auth::user()->id .") 
        AND status_id IN (3,5,7,10,12,14,17,19,21)");

        return view('approvals.my_rejected_requests',compact('myrequests')); 
    }

    public function editRequest($id)
    {
            $hosp =hs_hospital_history::find($id);

            $services = DB::table('hs_hospital_services_history')
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
            $lst_registration_status= Cache::remember('lst_registration_status', 60, function () {
                return DB::table('lst_registration_status')
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

         
            return view('approvals.edit_hospital',compact('hosp','current_services','lst_level_of_care','lst_states','lst_ownerships','lst_oparational_status',
            'lst_registration_status','lst_license_status','lst_services')); 
    }
    
    public function updateRequest(Request $request)
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
       
        // Update rejected create request, or update create request for reqeust that have not been verified yet
        if(in_array($request->status_id,[3,1])){  
            DB::beginTransaction();
            try {
                hs_hospital_history::disableAuditing();

                //update records in history with new changes
                $hosp = new hs_hospital_history;
                $hosp = hs_hospital_history::find($request->id);
                $hosp->fill($request->all());
                $hosp->status_id = 1;
                $hosp->requested_by = Auth::user()->id;
                $hosp->requested_at = Carbon::now()->format('Y-m-d H:i:s');
                $hosp->request_note = "";
                $hosp->verify_note = "";
                $hosp->validate_note = "";
                $hosp->publish_note = "";
                $hosp->start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date))); 
                $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
                $hosp->save();

                hs_hospital_history::enableAuditing();
                
                //insert in status tracking
                $status = new hs_status_tracking;
                $status->hospital_id = $request->id;
                $status->user_id = Auth::user()->id;
                $status->status_id = 1;
                $status->created_at = Carbon::now()->format('Y-m-d H:i:s');
                $status->save();

                //update hospital services
                hs_hospital_service_history::where('hospital_id', $request->id)->delete();
                        
                //insert services
                $services = $request->services;
                if (!empty($services)){
                    foreach ($services as $id){
                        $hosp_services = new hs_hospital_service_history;
                        $hosp_services->service_id = $id;
                        $hosp_services->hospital_id = $request->id; 
                        $hosp_services->save();
                    }            
                }
            DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }

        // MOdify request that have been rejected, this is the request for updating existing facility
        if(in_array($request->status_id,[8,10])){ 
            
            //restore main table data before being updated. Delete data in history and copy data from main
            //to history
            DB::beginTransaction();
            try {
                hs_hospital_history::disableAuditing();

                //delete hosp and services in history
                hs_hospital_history::destroy($request->id);
                hs_hospital_service_history::where('hospital_id', $request->id)->delete();

                $hosp_main = new hs_hospital;
                $hosp_main = hs_hospital::find($request->id);

                //copy data from main to history
                $hosp_history = new hs_hospital_history;
                $hosp_history -> fill($hosp_main->toArray());
                $hosp_history -> unique_id = $hosp_main->unique_id;
                $hosp_history -> start_date = $hosp_main->start_date;
                $hosp_history -> status_id = $hosp_main->status_id;
                $hosp_history -> created_by = $hosp_main->created_by;
                $hosp_history -> operational_days =  $hosp_main->operational_days;        
                $hosp_history -> save();
                //copy ends

                hs_hospital_history::enableAuditing();

                //update records in history with new changes
                $hosp = new hs_hospital_history;
                $hosp = hs_hospital_history::find($request->id);
                $hosp->fill($request->all());
                $hosp->status_id = 8;
                $hosp->request_note = "";
                $hosp->requested_at = Carbon::now()->format('Y-m-d H:i:s');  
                $hosp->requested_by = Auth::user()->id;
                $hosp->request_note = "";
                $hosp->verify_note = "";
                $hosp->validate_note = "";
                $hosp->publish_note = "";
                $hosp->start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date))); 
                $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
                $hosp->save();
                
                //insert in status tracking
                $status = new hs_status_tracking;
                $status->hospital_id = $request->id;
                $status->user_id = Auth::user()->id;
                $status->status_id = 8;
                $status->created_at = Carbon::now()->format('Y-m-d H:i:s');
                $status->save();

                //get services before update
                $services = DB::table('hs_hospital_services')
                        ->select('service_id')
                        ->where('hospital_id','=',$request->id)
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

    
                //update hospital services history if services are updated
                $services_equal = $hosp->array_equal($services_before, $services_update);

                if(!$services_equal){ 
                    hs_hospital_service_history::where('hospital_id', $request->id)->delete();

                    if (!empty($services_update)){
                        foreach ($services_update as $service_id){
                            $hosp_services = new hs_hospital_service_history;
                            $hosp_services->service_id = $service_id;
                            $hosp_services->hospital_id = $request->id; 
                            $hosp_services->save();
                        }         
                    }
                }


            DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
        
        session()->flash("alert-success", "Request Updated Successfully!");
        return redirect()->route('myrequest.pending');
    }
    
    
    public function deleteRequest(Request $request){
     
        // Delete my pending verification or rejected verification for new facility
        if(in_array($request->status_id,[1,3])){  

            //delete hosp and services in history
            DB::beginTransaction();
            try {
                hs_hospital_history::destroy($request->hosp_id);
                hs_hospital_service_history::where('hospital_id', $request->hosp_id)->delete();
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
        }
    

        // Delete pending verification or rejected verification for update requests
        //restore main table data before being udpated. Delete data in history and copy data from main to history
        if(in_array($request->status_id, [8,10])){ 
            DB::beginTransaction();
            try {
                hs_hospital_history::disableAuditing();

                //delete hosp and services in history
                hs_hospital_history::destroy($request->hosp_id);
                hs_hospital_service_history::where('hospital_id', $request->hosp_id)->delete();

                $hosp_main = new hs_hospital;
                $hosp_main = hs_hospital::find($request->hosp_id);

                //restore data from main tables to history
                $hosp_history = new hs_hospital_history;
                $hosp_history ->fill($hosp_main->toArray());
                $hosp_history ->unique_id = $hosp_main->unique_id;
                $hosp_history ->start_date = $hosp_main->start_date;
                $hosp_history ->status_id = $hosp_main->status_id;
                $hosp_history ->created_by = $hosp_main->created_by;
                $hosp_history ->operational_days =  $hosp_main->operational_days;        
                $hosp_history ->save();

                //copy services data from main to services history table
                $services = DB::select("SELECT service_id FROM hs_hospital_services WHERE hospital_id = ". $request->hosp_id . ""); 
    
                if(!empty($services)){
                    //add new services 
                    foreach ($services as $service){
                        $hosp_services = new hs_hospital_service_history;
                        $hosp_services->service_id = $service->service_id;
                        $hosp_services->hospital_id = $request->hosp_id; 
                        $hosp_services->save();
                    }
                }


                hs_hospital_history::enableAuditing();
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        }
        
        // Delete request for facility delition
        if(in_array($request->status_id, [15,17])){ 

            DB::beginTransaction();
            try {
                hs_hospital_history::disableAuditing();
                $hosp_main = new hs_hospital;
                $hosp_main = hs_hospital::find($request->hosp_id);

                $hosp = new hs_hospital_history;
                $hosp = hs_hospital_history::find($request->hosp_id);
                $hosp->status_id = $hosp_main->status_id;
                $hosp->verified_by =  $hosp_main->verified_by;
                $hosp->verified_at = $hosp_main->verified_at;
                $hosp->verify_note = $hosp_main->verified_note;
                $hosp->validated_by = $hosp_main->validate_by;
                $hosp->validated_at = $hosp_main->validate_at;
                $hosp->validate_note = $hosp_main->validate_note;
                $hosp->published_by = $hosp_main->published_by;
                $hosp->published_at = $hosp_main->published_at;
                $hosp->publish_note = $hosp_main->published_note;
                $hosp->save();      

                hs_hospital_history::enableAuditing();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

        }


        session()->flash("alert-success", "Request Deleted Successfully!");
        return redirect()->back();
    }


}
