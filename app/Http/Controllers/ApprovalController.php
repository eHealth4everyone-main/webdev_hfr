<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\hs_status_tracking;
use Auth;
use Carbon\Carbon;
use App\hs_hospital_history;
use App\audit;

class ApprovalController extends Controller
{
        
    public function myRequest()
    {
        $myrequests = DB::table('hospital_details_history')
            ->Where('created_by', '=',Auth::user()->id)
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
            $message = "Fcility Verification Rejected";
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
            ->get();

        $status = DB::table('hospital_status_tracking')
            ->where('state_id', '=', Auth::user()->state_id)
            ->orwhere('status_id','=','4')
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
            $message = "Fcility Verification Rejected";
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
    public function getUpdatedRecords($id)
    {
        $audit_id = DB::table('audits')
            ->select('id')
            ->where('event', '=', 'updated')
            ->where('auditable_type','=','App\hs_hospital_history')
            ->where('auditable_id','=',$id)
            ->orderBy('id', 'DESC')
            ->first();
    
        $hosp = hs_hospital_history::find($id);
      
        $audit = $hosp->audits()->find($audit_id->id);
        $audits= $audit->getModified();

        // $lookup_ids=array("state"=>"state_id","lga"=>"lga_id","ward"=>"ward_id","ownership"=>"ownership_id",
        //     "ownership_type"=>"ownership_type_id","facility_level"=>"facility_level_id",
        //     "facility_level_option"=>"facility_level_option_id","operation_status"=>"operational_status_id",
        //     "regulatory_status"=>"regulatory_status_id","license_status"=>"license_status_id");

        // $id_array=array("state_id","lga_id","ward_id","ownership_id","ownership_type_id","facility_level_id","facility_level_option_id",
        //     "operational_status_id","regulatory_status_id","license_status_id");

        // $fields = array();
        // foreach ($audits as $attr=>$audit){
        //     if(in_array($attr,$id_array)){    
        //         $fields[]=array_search($attr,$lookup_ids);
        //     }
        //     else{
        //         $fields[]=$attr;
        //     }
        // };

        // //new values
        // $new_values = DB::table('hospital_details_history')
        //     ->select($fields)
        //     ->where('id','=',$id)
        //     ->orderBy('id', 'DESC')
        //     ->first();

        // //old values
        // $old_values = DB::table('hospital_details')
        //     ->select($fields)
        //     ->where('id','=',$id)
        //     ->first(); 
        
        // dd($old_values->start_date,$new_values);
        
        
        //create loolup array to display in view
        $lookup=array("Registration No"=>"registration_no","Commencement Date"=>"start_date","Facility Name"=>"facility_name","Alternate Facility Name"=>"alt_facility_name",
            "State"=>"state_id","LGA"=>"lga_id","Wad"=>"ward_id","Ownership"=>"ownership_id","Ownership Type"=>"ownership_type_id","Ownership Details"=>"ownership_details",
            "Hospital/ Clinic Level"=>"facility_level_id","Facility Level Options"=>"facility_level_option_id","Specialized Options"=>"facility_level_options_category_id",
            "House Number"=>"house_no","Street Name"=>"street_name","Latitude"=>"longitude","Longitude"=>"latitude","Postal Address"=>"postal_address","Phone Number"=>"phone_number",
            "Email Address"=>"email_address","Website"=>"website","Days of Operation"=>"operational_days","Hours of Operation"=>"operational_hours","Operation Status"=>"operational_status_id",
            "Regulatory Status"=>"regulatory_status_id","License Status"=>"license_status_id","Medical Doctors"=>"doctors","Pharmacists"=>"pharmacists",
            "Dentists"=>"dentist","Pharmacy Technicians"=>"pharmacy_technicians","Nurses (Single)"=>"nurses","Laboratory Scientists"=>"lab_scientists",
            "Midwifes (Single)"=>"midwifes","Laboratory Technicians"=>"lab_technicians","Nurse/ Midwife (Double)"=>"nurse_midwife","Health Records/HIM Officers"=>"him_officers",
            "Community Health Officer"=>"community_health_officer","Community Health Extension Worker"=>"community_extension_workers","Junior Com Health Extension Worker"=>"jun_community_extension_worker",
            "Dental Technicians"=>"dental_technicians","Environmental Health Officers"=>"env_health_officers","Accidents and Emergency (Number of Beds)"=>"beds_accidents_emerg",
            "Admission Facilities (Number of Beds) "=>"beds_adminission","Intensive Care Unit (Number of Beds)"=>"beds_icu"," Onsite Pharmacy"=>"onsite_laboratory"," Onsite Laboratory"=>"onsite_imaging",
            " Onsite Imaging/ Radio-Diagnostics Center"=>"onsite_pharmarcy"," Mortuary Services"=>"mortuary_services");

        return view('approvals.updates',compact('audits','lookup'));      
    }
}
