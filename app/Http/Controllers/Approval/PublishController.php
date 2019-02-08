<?php

namespace App\Http\Controllers\Approval;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\hs_status_tracking;
use Auth;
use Carbon\Carbon;
use App\hs_hospital;
use App\hs_hospital_history;
use App\hs_hospital_service;
use App\hs_hospital_service_history;
use App\audit;
use App\Notifications\FacilityApproved;
use App\Notifications\ApprovalRejected;

class PublishController extends Controller
{
    public function index()
    {
        $pending = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->whereIn('status_id',[4,11,18])
            ->get();

        
        return view('approvals.pending_publish',compact('pending'));
    }
    
    public function store(Request $request)
    {                 
        if($request->action == "approve"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 6;
                $message = "Facility Published";
                $action="Create Published";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 13;
                $message = "Facility Update Published";
                $action="Update Published";
            }
            else{
                $status_id = 20;
                $message = "Facility Deleted";
                $action="Delete Published";
            }
        }

        if($request->action == "reject"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 7;
                $message = "Facility Publish Rejected";
                $action="Create Publish Rejected";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 14;
                $message = "Facility Publish Rejected";
                $action="Update Publish Rejected";
            }
            else{
                $status_id = 21;
                $message = "Facility Publish Rejected";
                $action="Delete Publish Rejected";              
            }
        }
        
        DB::beginTransaction();
        try {
            $date = Carbon::now()->format('Y-m-d H:i:s');
            hs_hospital_history::disableAuditing();      
            $hosp = new hs_hospital_history();
            $hosp = hs_hospital_history::findOrFail($request->id);
            $hosp->status_id = $status_id;
            $hosp->published_by = Auth::user()->id;
            $hosp->published_at = $date;
            $hosp->publish_note = $request->notes;
            $hosp->save();
            hs_hospital_history::enableAuditing();
        
            $status = new hs_status_tracking;
            $status->hospital_id = $request->id;
            $status->user_id = Auth::user()->id;
            $status->status_id = $status_id;
            $status->note = $request->notes;
            $status->created_at = $date;
            $status->save();
        

           //insert new facility data to main table after published
           if($status_id == 6){
                $hosp_history = new hs_hospital_history;
                $hosp_history = hs_hospital_history::find($request->id);

                //copy data from  history to main
                $hosp_main = new hs_hospital;  
                $hosp_main -> fill($hosp_history->toArray());
                $hosp_main -> unique_id = $hosp_history->unique_id;
                $hosp_main -> start_date = $hosp_history->start_date;
                $hosp_main -> status_id = $hosp_history->status_id;
                $hosp_main -> created_by = $hosp_history->created_by;
                $hosp_main -> operational_days =  $hosp_history->operational_days;        
                $hosp_main -> save();
                //copy ends

                //get new hospital services
                $services = DB::select("SELECT service_id FROM hs_hospital_services_history WHERE hospital_id = ". $request->id . ""); 

                //insert services
                if(!empty($services)){
                    foreach ($services as $service){
                        $hosp_services = new hs_hospital_service;
                        $hosp_services->service_id = $service->service_id;
                        $hosp_services->hospital_id = $request->id; 
                        $hosp_services->save();
                    }
                }
                
            }


            //update hospital, and hospital services to main table
            if($status_id == 13){
                $hosp_history = new hs_hospital_history;
                $hosp_history = hs_hospital_history::find($request->id);

                //copy data from  history to main
                $hosp_main = new hs_hospital;  
                $hosp_main = hs_hospital::find($request->id);
                $hosp_main -> fill($hosp_history->toArray());
                $hosp_main -> start_date = $hosp_history->start_date;
                $hosp_main -> status_id = $hosp_history->status_id;
                $hosp_main -> created_by = $hosp_history->created_by;
                $hosp_main -> operational_days =  $hosp_history->operational_days;        
                $hosp_main -> save();
                //copy ends

                //get new hospital services
                $services = DB::select("SELECT service_id FROM hs_hospital_services_history WHERE hospital_id = ". $request->id . ""); 
    
                if(!empty($services)){
                    // remove current services in main table
                    $deleted = DB::delete("delete from hs_hospital_services where hospital_id ='". $request->id ."' and id > 0");
                    
                    //add new services 
                    foreach ($services as $service){
                        $hosp_services = new hs_hospital_service;
                        $hosp_services->service_id = $service->service_id;
                        $hosp_services->hospital_id = $request->id; 
                        $hosp_services->save();
                    }
                }
            }
        

            //Delete facility after final delete request published
            if($status_id == 20){
                hs_hospital_service::where('hospital_id', $request->id)->delete();
                hs_hospital::destroy($request->id);
            }

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        //****** send notifications *********

        //get users with in the state and send them notifcaion after final verifcation
        // if($request->action == "approve"){      
        //     $users = DB::select("SELECT id FROM users where state_id = ". $hosp->state_id ."");
            
        //     foreach ($users as $user){
        //         $user = user::find($user->id);
        //         $user->notify(new FacilityVerifiedLevel2($message,$request->id));
        //     }  
        // } 

        // if($request->action == "reject"){ // if rejected send notification to verifier 1
        //     $userid = $hosp->verified_lv1_by;
        //     $user = user::find($userid);
        //     $user->notify(new VerificationRejectedLevel2($message,$request->id));
        // }

        session()->flash("alert-success", $message);
        return redirect()->route('publish.pending');
    }
    
}
