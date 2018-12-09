<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\hs_status_tracking;
use Auth;
use Carbon\Carbon;
use App\hs_hospital_history;

class ApprovalController extends Controller
{
        
    public function myRequest()
    {
        $myrequests = DB::table('hospital_details_history')
            ->Where('created_by', '=',Auth::user()->id)
            ->paginate(15);

        $status = DB::table('hospital_status_tracking')
            ->Where('user_id', '=', Auth::user()->id)
            ->get();

        return view('approvals.my_requests',compact('myrequests','status')); 
    }
    public function pendingApproval()
    {
        $pending  = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->where('status_id','=','1')
            ->orwhere('status_id','=','5')
            ->paginate(15);
        
     
        return view('approvals.pending_approval',compact('pending')); 
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
        ->paginate(15);
    
        
        return view('approvals.pending_Verification1',compact('pending'));
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
            ->paginate(15);
        
        
        return view('approvals.pending_Verification2',compact('pending'));
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
}
