<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\hs_status_tracking;
use Auth;
use Carbon\Carbon;
use App\hs_hospital_history;
use App\hs_hospital_service;
use App\audit;

class ApprovalController extends Controller
{
        
    public function myRequest()
    {
        $myrequests = DB::table('hospital_details_history')
            ->orWhere('created_by', '=',Auth::user()->id)
            ->orWhere('requested_by', '=',Auth::user()->id)
            ->orderby('updated_at','desc')
            ->paginate(20);

        $status = DB::table('hospital_status_tracking')
            ->where('state_id', '=', Auth::user()->state_id)
            ->get();

        return view('approvals.my_requests',compact('myrequests','status')); 
    }
    public function pendingApproval()
    {
        $pending = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->where('status_id','=','1')
            ->orwhere('status_id','=','5')
            ->orwhere('status_id','=','8')
            ->orwhere('status_id','=','12')
            ->orderby('updated_at','desc')
            ->get();

        $status = DB::table('hospital_status_tracking')
            ->where('state_id', '=', Auth::user()->state_id)
            ->orwhere('status_id','=','1')
            ->get();
     
        return view('approvals.pending_approval',compact('pending','status')); 
    }

    public function storeApproval(Request $request)
    {
        if($request->action == "approve"){
            $status_id = 2;
            $notes = $request->notes;
            $action="Create Approved";
            $message = "New Facility Creation Approved";
        }
        if($request->action == "reject"){
            $status_id = 3;
            $notes = $request->notes;
            $action="Create Rejected";
            $message = "New Facility Creation Rejected";
        }
       
        $time = Carbon::now()->format('Y-m-d H:i:s');
      
        $hosp = new hs_hospital_history;
        $hosp = hs_hospital_history::findOrFail($request->id);
        $hosp->status_id = $status_id;
        $hosp->save();
    
        $status = new hs_status_tracking;
        $status->hospital_id = $request->id;
        $status->action = $action;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $notes;
        $status->created_at = $time;
        $status->save();
    
        session()->flash("alert-success", $message);
        return redirect()->back();
    }

    public function pendingVerification1()
    {
        $pending  = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->where('status_id','=','2')
            ->orwhere('status_id','=','7')
            ->orwhere('status_id','=','9')
            ->get();

        $status = DB::table('hospital_status_tracking')
            ->where('state_id', '=', Auth::user()->state_id)
            ->orwhere('status_id','=','2')
            ->get();
            
        return view('approvals.pending_verification1',compact('pending','status'));
    }

    public function storeVerification1(Request $request)
    {
        if($request->action == "approve"){
            $status_id = 4;
            $notes = $request->notes;
            $message = "Facility Creation Verified";
            $action="Create Verified (Lv1)";
        }
        if($request->action == "reject"){
            $status_id = 5;
            $notes = $request->notes;
            $message = "Facility Verification Rejected";
            $action="Create Rejected (Lv1)";
        }
       
        $time = Carbon::now()->format('Y-m-d H:i:s');
      
        $hosp = new hs_hospital_history();
        $hosp = hs_hospital_history::findOrFail($request->id);
        $hosp->status_id = $status_id;
        $hosp->save();
    
        $status = new hs_status_tracking;
        $status->hospital_id = $request->id;
        $status->action = $action;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $notes;
        $status->created_at = $time;
        $status->save();
    
        session()->flash("alert-success", $message);
        return redirect()->back();
    }

    public function pendingVerification2()
    {
        $pending  = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->where('status_id','=','4')
            ->orwhere('status_id','=','11')
            ->get();

        $status = DB::table('hospital_status_tracking')
            ->where('state_id', '=', Auth::user()->state_id)
            ->orwhere('status_id','=','4')
            ->orwhere('status_id','=','11')
            ->get();
            
        
        return view('approvals.pending_verification2',compact('pending','status'));
    }
    
    public function storeVerification2(Request $request)
    {
        if($request->action == "approve"){
            $status_id = 6;
            $notes = $request->notes;
            $message = "Facility Creation Verified";
            $action="Create Verified (Lv2)";
        }
        if($request->action == "reject"){
            $status_id = 7;
            $notes = $request->notes;
            $message = "Facility Verification Rejected";
            $action="Create Rejected (Lv2)";
        }
       
        $time = Carbon::now()->format('Y-m-d H:i:s');
      
        $hosp = new hs_hospital_history();
        $hosp = hs_hospital_history::findOrFail($request->id);
        $hosp->status_id = $status_id;
        $hosp->save();
    
        $status = new hs_status_tracking;
        $status->hospital_id = $request->id;
        $status->action = $action;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $notes;
        $status->created_at = $time;
        $status->save();
    
        session()->flash("alert-success", $message);
        return redirect()->back();
    }
    
    public function getUpdatedRecords($id,$stage)
    {
        $audit_id = DB::table('audits')
            ->select('id')
            ->where('event', '=', 'updated')
            ->where('auditable_type','=','App\hs_hospital_history')
            ->where('auditable_id','=',$id)
            ->where('url','like','%'. $id . '%')            
            ->orderBy('id', 'DESC')
            ->first();
    
        $hosp = hs_hospital_history::find($id);
        $audit = $hosp->audits()->find($audit_id->id);
        $audits= $audit->getModified();

        //new values
        $new_values = DB::table('hospital_details_history')
            ->select('state','lga','ward','ownership','ownership_type','facility_level',
            'facility_level_option','operation_status','regulatory_status','license_status')
            ->where('id','=',$id)
            ->orderBy('id', 'DESC')
            ->first();

        //old values
        $old_values = DB::table('hospital_details')
            ->select('state','lga','ward','ownership','ownership_type','facility_level',
            'facility_level_option','operation_status','regulatory_status','license_status')
            ->where('id','=',$id)
            ->first(); 
        
        //get new hospital services
        $new_services = DB::select("SELECT s.name FROM hs_hospital_services_history h
            JOIN lst_hosp_services s ON s.id = h.service_id where h.hospital_id = ". $id . "");
        
        //get old hospital services
        $old_services = DB::select("SELECT s.name FROM hs_hospital_services h
        JOIN lst_hosp_services s ON s.id = h.service_id where h.hospital_id = ". $id . "");


        //dd($old_services, $new_services);

       //create loolup array to display in view
       $lookup=array("Registration No"=>"registration_no","Commencement Date"=>"start_date","Facility Name"=>"facility_name","Alternate Facility Name"=>"alt_facility_name",
        "State"=>"state_id","LGA"=>"lga_id","Ward"=>"ward_id","Ownership"=>"ownership_id","Ownership Type"=>"ownership_type_id","Ownership Details"=>"ownership_details",
        "Hospital/ Clinic Level"=>"facility_level_id","Facility Level Options"=>"facility_level_option_id","Specialized Options"=>"facility_level_options_category_id",
        "House Number"=>"house_no","Street Name"=>"street_name","Latitude"=>"longitude","Longitude"=>"latitude","Postal Address"=>"postal_address","Phone Number"=>"phone_number",
        "Email Address"=>"email_address","Website"=>"website","Days of Operation"=>"operational_days","Hours of Operation"=>"operational_hours","Operation Status"=>"operational_status_id",
        "Regulatory Status"=>"regulatory_status_id","License Status"=>"license_status_id","Medical Doctors"=>"doctors","Pharmacists"=>"pharmacists",
        "Dentists"=>"dentist","Pharmacy Technicians"=>"pharmacy_technicians","Nurses (Single)"=>"nurses","Laboratory Scientists"=>"lab_scientists",
        "Midwifes (Single)"=>"midwifes","Laboratory Technicians"=>"lab_technicians","Nurse/ Midwife (Double)"=>"nurse_midwife","Health Records/HIM Officers"=>"him_officers",
        "Community Health Officer"=>"community_health_officer","Community Health Extension Worker"=>"community_extension_workers","Junior Com Health Extension Worker"=>"jun_community_extension_worker",
        "Dental Technicians"=>"dental_technicians","Environmental Health Officers"=>"env_health_officers","Accidents and Emergency (Number of Beds)"=>"beds_accidents_emerg",
        "Admission Facilities (Number of Beds) "=>"beds_adminission","Intensive Care Unit (Number of Beds)"=>"beds_icu","Onsite Laboratory"=>"onsite_laboratory",
        "Onsite Imaging/ Radio-Diagnostics Center"=>"onsite_imaging","Onsite Pharmacy"=>"onsite_pharmarcy","Mortuary Services"=>"mortuary_services");

        $hosp_id = $id;
        $name=($hosp->facility_name);

        if ($stage=='approve'){
            return view('approvals.updates_approve',compact('audits','lookup','old_values','new_values','hosp_id','name','old_services','new_services')); 
        }
        if ($stage=='verify1'){
            return view('approvals.updates_verify1',compact('audits','lookup','old_values','new_values','hosp_id','name','old_services','new_services')); 
        }
        if ($stage=='verify2'){
            return view('approvals.updates_verify2',compact('audits','lookup','old_values','new_values','hosp_id','name','old_services','new_services')); 
        }
    }
    
    public function storeUpdatedApproval(Request $request)
    {
       // dd($request->all());

        if($request->action == "approve"){
            $status_id = 9;
            $notes = $request->notes;
            $action="Update Approved";
            $message = "Facility Update Approved";
        }
        if($request->action == "reject"){
            $status_id = 10;
            $notes = $request->notes;
            $action="Update Rejected";
            $message = "Facility Update Rejected";
        }
      
        $time = Carbon::now()->format('Y-m-d H:i:s');

        $hosp = new hs_hospital_history;
        $hosp = hs_hospital_history::findOrFail($request->id);
        $hosp->status_id = $status_id;
        $hosp->save();

        $status = new hs_status_tracking;
        $status->hospital_id = $request->id;
        $status->action = $action;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $notes;
        $status->created_at = $time;
        $status->save();
    
        session()->flash("alert-success", $message);
        return redirect()->route('view.pendingapproval');
    }

  
    public function storeUpdatedVerification1(Request $request)
    {
        if($request->action == "approve"){
            $status_id = 11;
            $notes = $request->notes;
            $message = "Facility Update Verified";
            $action="Update Verified (Lv1)";
        }
        if($request->action == "reject"){
            $status_id = 12;
            $notes = $request->notes;
            $message = "Facility Update Verification Rejected";
            $action="Update Rejected (Lv1)";
        }
       
        $time = Carbon::now()->format('Y-m-d H:i:s');
      
        $hosp = new hs_hospital_history();
        $hosp = hs_hospital_history::findOrFail($request->id);
        $hosp->status_id = $status_id;
        $hosp->save();
    
        $status = new hs_status_tracking;
        $status->hospital_id = $request->id;
        $status->action = $action;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $notes;
        $status->created_at = $time;
        $status->save();
    
        session()->flash("alert-success", $message);
        return redirect()->route('view.pendingverification1');

    }

    public function storeUpdatedVerification2(Request $request)
    {
        if($request->action == "approve"){
            $status_id = 13;
            $notes = $request->notes;
            $message = "Facility Update Verified";
            $action="Update Verified (Lv2)";
        }
        if($request->action == "reject"){
            $status_id = 14;
            $notes = $request->notes;
            $message = "Facility Update Verification Rejected";
            $action="Update Rejected (Lv2)";
        }
       
        $time = Carbon::now()->format('Y-m-d H:i:s');
      
        $hosp = new hs_hospital_history();
        $hosp = hs_hospital_history::findOrFail($request->id);
        $hosp->status_id = $status_id;
        $hosp->save();
    
        $status = new hs_status_tracking;
        $status->hospital_id = $request->id;
        $status->action = $action;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $notes;
        $status->created_at = $time;
        $status->save();

        //update hospital services to main table
        if($status_id == 13){
            //get new hospital services
            $services = DB::select("SELECT service_id FROM hs_hospital_services_history WHERE hospital_id = ". $request->id . ""); 

            if(!empty($services)){
                // remove current services in main table
                $deleted = DB::delete("delete from hs_hospital_services where hospital_id ='". $request->id ."' and id > 0");

                foreach ($services as $service){
                    $hosp_services = new hs_hospital_service;
                    $hosp_services->service_id = $service->service_id;
                    $hosp_services->hospital_id = $request->id; 
                    $hosp_services->save();
                }
            }
        }
    
        session()->flash("alert-success", $message);
        return redirect()->route('view.pendingverification2');

    }
}
