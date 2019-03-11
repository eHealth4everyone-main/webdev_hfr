<?php

namespace App\Http\Controllers\Approval;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\StatusTracking;
use Auth;
use Carbon\Carbon;
use App\HospitalHistory;
use App\HospitalServiceHistory;
use App\audit;
use App\Notifications\FacilityVerifiedLevel1;
use App\Notifications\VerificationRejectedLevel1;

class VerifyController extends Controller
{
    public function index()
    {
        $pending = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->whereNotIn('status_id',[3,6,10,13,17,20])
            ->orderby('updated_at','desc')
            ->get();
     
        return view('approvals.pending_verify',compact('pending')); 
    }

    public function store(Request $request)
    {
       
        HospitalHistory::disableAuditing();       
        $hosp = new HospitalHistory;
        $hosp = HospitalHistory::findOrFail($request->id);

        if($request->action == "approve"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 2;
                $action="Create Verified";
                $message = "Facility Creation Verified";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 9;
                $action="Update Verified";
                $message = "Facility Update Verified";
            }
            else{
                $status_id = 16;
                $action="Delete Verified";
                $message = "Facility Deletion Verified";
            }
             //clear publish and validate fields after reqest rejected then re submiited
             $hosp->validated_by =  $request->validated_by;
             $hosp->validated_at =  $request->validated_at;
             $hosp->validate_note = $request->validate_note;
             $hosp->published_by = $request->published_by;
             $hosp->published_at = $request->published_at;
             $hosp->publish_note = $request->publish_note;
        }

        if($request->action == "reject"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 3;
                $action="Create Verification Rejected";
                $message = "Facility Creation Rejected";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 10;
                $action="Update Verification Rejected";
                $message = "Facility Update Rejected";
            }
            else{
                $status_id = 17;
                $action="Delete Verification Rejected";
                $message = "Facility Deletion Rejected";
            }
        }
    
        $date = Carbon::now()->format('Y-m-d H:i:s');

        $hosp->status_id = $status_id;
        $hosp->verified_by = Auth::user()->id;
        $hosp->verified_at = $date;
        $hosp->verify_note = $request->notes;
    
        $status = new StatusTracking;
        $status->hospital_id = $request->id;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $request->notes;
        $status->created_at =  $date;

        DB::beginTransaction();
        try {
            $hosp->save();
            $status->save();
     
            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        HospitalHistory::enableAuditing();


        //****** send notifications *********
        //get users with verification level 1 access
        // if($request->action == "approve"){
        //     $users = DB::select("SELECT u.id FROM users u
        //             JOIN model_has_roles r on r.model_id = u.id
        //             JOIN role_has_permissions p on p.role_id = r.role_id
        //             WHERE p.permission_id = 60 and u.state_id = ". $hosp->state_id ."");
            
        //     foreach ($users as $user){
        //         $user = user::find($user->id);
        //         $user->notify(new FacilityApproved($message,$request->id));
        //     }  
        // }


        // if($request->action == "reject"){ // if rejected send notification to requester
        //     if($request->requested_action == "CREATE FACILITY"){
        //         $userid = $hosp->created_by;
        //     }
        //     else{
        //         $userid = $hosp->requested_by;
        //     }

        //     $user = user::find($userid);
        //     $user->notify(new ApprovalRejected($message,$request->id));
        // }


        //mark as read the notification
        // $notification_id = DB::select("select id from notifications where type like '%teRequest' and 
        // notifiable_id=". Auth::user()->id ." and data like '%" . $request->id . "%' and read_at is null");

        // if (!empty($notification_id)){
        //     auth()->user()->unreadNotifications->where('id', $notification_id[0]->id)->markAsRead();
        // }

        // ****** notifiction end *****
        session()->flash("alert-success", $message);
        return redirect()->route('verify.pending');
    }

    public function recall(Request $request)
    {
        if($this->isVerified($request->hosp_id)){
            if($request->action == "CREATE FACILITY"){
                $status_id = 1;
                $action="Recall Create Verification";
            }
            elseif($request->action == "UPDATE FACILITY"){
                $status_id = 8;
                $action="Recall Update Verification";
            }
            else{
                $status_id = 15;
                $action="Recall Delete Verification";
            }
    
        
            $date = Carbon::now()->format('Y-m-d H:i:s');
    
            HospitalHistory::disableAuditing();       
            $hosp = new HospitalHistory;
            $hosp = HospitalHistory::findOrFail($request->hosp_id);
            $hosp->status_id = $status_id;
            $hosp->verified_by = $request->verified_by;
            $hosp->verified_at = $request->verified_at;
            $hosp->verify_note = $request->verified_note;
        
            $status = new StatusTracking;
            $status->hospital_id = $request->hosp_id;
            $status->user_id = Auth::user()->id;
            $status->status_id = $status_id;
            $status->created_at =  $date;
            $status->note = $action;
    
            DB::beginTransaction();
            try {
                $hosp->save();
                $status->save();
         
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }
    
            HospitalHistory::enableAuditing();
    
            session()->flash("alert-success", "Verification recalled successfully!");
        }
        else{
            session()->flash("alert-success", "Can not recall validated or published request!");
        }

        return redirect()->route('verify.pending');
       
    }

    private function isVerified($id){
        $hosp = HospitalHistory::find($id);
       
        if (in_array($hosp->status_id,[2,9,16])){
            return true;
        }else{
            return false;
        }
    }

}
