<?php

namespace App\Http\Controllers\Approval;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\StatusTracking;
use Auth;
use Carbon\Carbon;
use App\Hospital;
use App\HospitalHistory;
use App\HospitalService;
use App\HospitalServiceHistory;
use App\audit;
use App\ApprovalNotifications;
use App\HfrDhis;

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

    public function search(Request $request)
    {
        if ($request->status ==1){
            $pending = DB::table('hospital_details_history')
            ->where('state_id', '=',Auth::user()->state_id)
            ->whereIn('status_id',[4,11,18])
            ->get();
        }
        elseif($request->status ==2){
            $pending = DB::table('hospital_details_history')
            ->where('published_id', '=',Auth::user()->id)
            ->whereIn('status_id',[6,13,20])
            ->get();
        }
        elseif($request->status ==3){
            $pending = DB::table('hospital_details_history')
            ->where('published_id', '=',Auth::user()->id)
            ->whereIn('status_id',[7,14,21])
            ->get();
        }
        else{
            $pending = DB::table('hospital_details_history')
            ->where('published_id', '=',Auth::user()->id)
            ->orderby('updated_at','desc')
            ->get();
        }

        return view('approvals.pending_publish',compact('pending'));
    }

    public function store(Request $request)
    {                
        HospitalHistory::disableAuditing();      
        $hosp = new HospitalHistory();
        $hosp = HospitalHistory::find($request->id);
        $facility_name = $hosp['facility_name'];
        $state_id = $hosp['state_id'];
        $mail_subject="";

        if($request->action == "approve"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 6;
                $message = "Facility Published";
                $action="Create Published";
                $mail_subject = "New Facility Created";
                $mail_message = "New facility: '". $facility_name. "' is created";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 13;
                $message = "Facility Update Published";
                $action="Update Published";
                $mail_subject = "Facility Updated";
                $mail_message = "Facility: '". $facility_name. "' is updated";
            }
            else{
                $status_id = 20;
                $message = "Facility Deleted";
                $action="Delete Published";
                $mail_subject = "Facility Deleted";
                $mail_message = "Facility: '". $facility_name. "' is deleted";                
            }
        }

        if($request->action == "reject"){
            if($request->requested_action == "CREATE FACILITY"){
                $status_id = 7;
                $message = "Facility Publish Rejected";
                $action="Create Publish Rejected";
                $mail_message = "Publisher has rejected facility creation request. Please login to the system to review your request.";
            }
            elseif($request->requested_action == "UPDATE FACILITY"){
                $status_id = 14;
                $message = "Facility Publish Rejected";
                $action="Update Publish Rejected";
                $mail_message = "Publishere has rejected facility update request. Please login to the system to review your request.";
            }
            else{
                $status_id = 21;
                $message = "Facility Publish Rejected";
                $action="Delete Publish Rejected";      
                $mail_message = "Publisher has rejected facility deletion request. Please login to the system to review your request.";
            }
        }
        
        DB::beginTransaction();
        try {

            // $date = Carbon::now()->format('Y-m-d H:i:s');
          
            // $hosp->status_id = $status_id;
            // $hosp->published_by = Auth::user()->id;
            // $hosp->published_at = $date;
            // $hosp->publish_note = $request->notes;
            // $hosp->save();
            // HospitalHistory::enableAuditing();
        
            // $status = new StatusTracking;
            // $status->hospital_id = $request->id;
            // $status->user_id = Auth::user()->id;
            // $status->status_id = $status_id;
            // $status->note = $request->notes;
            // $status->created_at = $date;
            // $status->save();
        
           //insert new facility data to main table after published
            if($status_id == 6){
                    $hosp_history = new HospitalHistory;
                    $hosp_history = HospitalHistory::find($request->id);

                    //copy data from  history to main
                    $hosp_main = new Hospital;  
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
                            $hosp_services = new HospitalService;
                            $hosp_services->service_id = $service->service_id;
                            $hosp_services->hospital_id = $request->id; 
                            $hosp_services->save();
                        }
                    }
                    
            }

            //update hospital, and hospital services to main table
            if($status_id == 13){
                // $hosp_history = new HospitalHistory;
                // $hosp_history = HospitalHistory::find($request->id);

                // //copy data from  history to main
                // $hosp_main = new Hospital;  
                // $hosp_main = Hospital::find($request->id);
                // $hosp_main -> fill($hosp_history->toArray());
                // $hosp_main -> start_date = $hosp_history->start_date;
                // $hosp_main -> status_id = $hosp_history->status_id;
                // $hosp_main -> created_by = $hosp_history->created_by;
                // $hosp_main -> operational_days =  $hosp_history->operational_days;        
                // $hosp_main -> save();
                // //copy ends

                // //get new hospital services
                // $services = DB::select("SELECT service_id FROM hs_hospital_services_history WHERE hospital_id = ". $request->id . ""); 
    
                // if(!empty($services)){
                //     // remove current services in main table
                //     $deleted = DB::delete("delete from hs_hospital_services where hospital_id ='". $request->id ."' and id > 0");
                    
                //     //add new services 
                //     foreach ($services as $service){
                //         $hosp_services = new HospitalService;
                //         $hosp_services->service_id = $service->service_id;
                //         $hosp_services->hospital_id = $request->id; 
                //         $hosp_services->save();
                //     }
                // }
            }
            
            //Delete facility after final delete request published
            if($status_id == 20){
                HospitalService::where('hospital_id', $request->id)->delete();
                Hospital::destroy($request->id);
            }

            DB::commit();
        } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
        }

        //****** Send Notifications *********
        // $notify = new ApprovalNotifications;
        // $notify->sendPublicationNotification($mail_message,$request->action,$mail_subject,$state_id);

        session()->flash("alert-success", $message);

        if ($status_id == 6){
            return view('dhis.store',compact('hosp','message'));
        }
        elseif($status_id == 13){
            $data = $this->getDhisUpdatedValues($hosp, $request->id);
            
            if ($data != 'false'){
                $dhis = new HfrDhis;
                $response = $dhis->sendUpdatesToDHIS($data,$request->id);
                dd($response);

            }else{
                return redirect()->route('publish.pending');
            }
        }else{
            return redirect()->route('publish.pending');
        }
    }

    public function getDhisUpdatedValues($hosp,$id){
        $audit_id = DB::table('audits')
            ->select('id')
            ->where('event', '=', 'updated')
            ->where('auditable_type','=','App\HospitalHistory')
            ->where('auditable_id','=',$id)
            ->orderBy('id', 'DESC')
            ->first();

        $hosp = HospitalHistory::find($id);
        $audit = $hosp->audits()->find($audit_id->id);
        $allUpdatedValues= $audit->getModified();

        $dhisFields = ["facility_name","alt_facility_name","start_date","close_date","postal_address","email_address","website",
          "phone_number","longitude","latitude","ownership_id","facility_level_id","facility_level_option_id"];
        
        $dhisUpdatedFields = array_intersect($dhisFields, array_keys($allUpdatedValues));
        
  
        if (count($dhisUpdatedFields) > 0) {  //there is at least one dhis field updated
            $dhis = new HfrDhis;

            $data = [];
            $orgUnitGroups =[];
        
            $data = [
                'name' =>$dhis->formatName($hosp['facility_name'], $hosp['state_id']),
                'shortName' => $dhis->getShortname($hosp['facility_name'],$hosp['alt_facility_name']),
                'code' => $id,
                'openingDate' => $dhis->formatDate($hosp['start_date']),
                'closedDate' =>$dhis->formatDate($hosp['close_date']),
                'address' => $hosp['postal_address'],
                'coordinates' => $dhis->formatGeoCords($hosp['longitude'],$hosp['latitude']),
                'email' => $hosp['email_address'],
                'url' => $hosp['website'],
                'phoneNumber' => $hosp['phone_number'],
                'parent' => $dhis->getParent($hosp['ward_id'])
            ];

            foreach($allUpdatedValues as $key => $value) {
                if(in_array($key,$dhisUpdatedFields )){
                    switch ($key) {
                        case "ownership_id":
                            $orgUnitGroups['ownership_id'] = $value['new'];                          
                            break;
                        case "facility_level_id":
                            $orgUnitGroups['facility_level_id'] = $value['new'];                            
                            break;
                        case "facility_level_option_id":
                            $orgUnitGroups['facility_level_option_id'] = $value['new'];                          
                            break;
                    }
                    
                }
            }

            $dataArray['updates'] = $data;
            $dataArray['groups'] = $orgUnitGroups;

            return $dataArray;

        }else{
            return 'false';
        }

    }



    
}
