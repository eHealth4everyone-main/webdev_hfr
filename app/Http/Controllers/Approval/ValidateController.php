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
use App\Notifications\FacilityVerifiedLevel2;
use App\Notifications\VerificationRejectedLevel2;


class ValidateController extends Controller
{
    public function index()
    {
        $pending  = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->whereIn('status_id',[2,7,9,14,16,21,4,11,18])
            ->get();

        return view('approvals.pending_validation',compact('pending'));
    }

    public function store(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
       
        HospitalHistory::disableAuditing();        
        $hosp = new HospitalHistory();
        $hosp = HospitalHistory::findOrFail($request->id);

        if($request->action == "approve"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 4;
                $message = "Facility Creation Validated";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 11;
                $message = "Facility Update Validated";
            }
            else{
                $status_id = 18;
                $message = "Facility Deletion Validated";
            }

            //clear publish fields after reqest rejected at publish level and then re submiited
            $hosp->published_by = $request->published_by;
            $hosp->published_at = $request->published_at;
            $hosp->publish_note = $request->publish_note;
        }

        if($request->action == "reject"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 5;
                $message = "Facility Validation Rejected";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 12;
                $message = "Facility Validation Rejected";
            }
            else{
                $status_id = 19;
                $message = "Facility Validation Rejected";
            }
        }


        $hosp->status_id = $status_id;
        $hosp->validated_by = Auth::user()->id;
        $hosp->validated_at = $date;
        $hosp->validate_note = $request->notes;
        
        $status = new StatusTracking;
        $status->hospital_id = $request->id;
        $status->user_id = Auth::user()->id;
        $status->status_id = $status_id;
        $status->note = $request->notes;
        $status->created_at = $date;
    
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
        //get users with verification level 2 access
        // if($request->action == "approve"){      
        //     $users = DB::select("SELECT u.id FROM users u
        //     JOIN model_has_roles r on r.model_id = u.id
        //     JOIN role_has_permissions p on p.role_id = r.role_id
        //     WHERE p.permission_id = 61 and u.state_id = ". $hosp->state_id ."");
            
        //     foreach ($users as $user){
        //         $user = user::find($user->id);
        //         $user->notify(new FacilityVerifiedLevel1($message,$request->id));
        //     }  
        // }
        // if($request->action == "reject"){ // if rejected send notification to approver
        //     $userid = $hosp->approved_by;

        //     $user = user::find($userid);
        //     $user->notify(new VerificationRejectedLevel1($message,$request->id));
        // }

        session()->flash("alert-success", $message);
        return redirect()->route('validate.pending');
    }

     
    public function recall(Request $request)
    {
        if($this->isValidated($request->hosp_id)){

            if($request->action == "CREATE FACILITY"){
                $status_id = 2;
                $action="Recall Create Validation";
            }
            elseif($request->action == "UPDATE FACILITY"){
                $status_id = 9;
                $action="Recall Update Validation";
            }
            else{
                $status_id = 16;
                $action="Recall Delete Validation";
            }
      
            HospitalHistory::disableAuditing();       
            $hosp = new HospitalHistory;
            $hosp = HospitalHistory::findOrFail($request->hosp_id);
            $hosp->status_id = $status_id;
            $hosp->validated_by = $request->validated_by;
            $hosp->validated_at = $request->validated_at;
            $hosp->validate_note = $request->validate_note;
       
            $status = new StatusTracking;
            $status->hospital_id = $request->hosp_id;
            $status->user_id = Auth::user()->id;
            $status->status_id = $status_id;
            $status->created_at =  Carbon::now()->format('Y-m-d H:i:s');
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
    
            session()->flash("alert-success", "Validation recalled successfully!");
        }
        else{
            session()->flash("alert-success", "Can not recall validated or published request!");
        }
   
        return redirect()->route('validate.pending');       
    }

    private function isValidated($id){
        $hosp = HospitalHistory::find($id);
       
        if (in_array($hosp->status_id,[4,11,18])){
            return true;
        }else{
            return false;
        }
    }
}
