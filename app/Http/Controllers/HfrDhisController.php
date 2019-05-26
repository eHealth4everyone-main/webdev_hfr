<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\DhisLog;
use App\HfrDhis;
use Auth;

class HfrDhisController extends Controller
{
    public function index(){
        return view('dhis.index');    
    }

    public function store(Request $request){
        $dhis = new HfrDhis;

        $data= [];
        
        $data = [
            'name' =>$dhis->formatName($request->facility_name, $request->state_id),
            'shortName' => $dhis->getShortname($request->facility_name,$request->alt_facility_name),
            'code' => $request->id,
            'openingDate' => $dhis->formatDate($request->start_date),
            'closedDate' =>'',
            'address' => $request->postal_address,
            'coordinates' => $dhis->formatGeoCords($request->longitude,$request->latitude),
            'email' => $request->email_address,
            'url' => $request->website,
            'phoneNumber' => $request->phone_number,
            'parent' => $dhis->getParent($request->ward_id)
        ];
       
        try {
            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);
    
            $response = $client->post('organisationUnits', [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
                'json' => $data
            ]);


            if ($response->getReasonPhrase() ==  'Created'){
                $array = json_decode($response->getBody()->getContents(), true); 
              
                $facility_uid = $array['response']['uid'];
           
                //Assign Organisation unit - ownership
                $ownership_status = $dhis->assignOwnership($request->ownership_id,$facility_uid);

                //Assign Organisation unit - Level of Care
                $level_status = $dhis->assignLevelOfCare($request->facility_level_id, $facility_uid);
       
                //Assign Organisation unit - Level of Care Options
                if (in_array($request->facility_level_id,[1,3,5])){
                    $level_option_status = $dhis->assignLevelOfCareOption($request->facility_level_option_id,$facility_uid);
                }
                else{
                    $level_option_status = 'Not set';
                }

                //Save status of actions
                $log = new DhisLog;
                $log->hfr_id = $request->id;
                $log->dhis_uid = $facility_uid;
                $log->facility_status = 'Created';
                $log->ownership_status = $ownership_status;
                $log->level_status = $level_status;
                $log->level_option_status = $level_option_status;
                $log->user_id = Auth::user()->id;
                $log->save();

                //send notification email to dhis team
                $dhis->sendEmailtoDhisTeamForNewFacility($request->facility_name, $request->ward_id);

                return 'Created';
            }
        
        } catch (RequestException $e) {
            $log = new DhisLog;
            if ($e->hasResponse()) {
                $response =  Psr7\str($e->getResponse());
                $log->hfr_id = $request->id;
                $log->facility_status = $response;
                $log->user_id = Auth::user()->id;
                $log->save();
                return "Exception Error";
            }else {
                $log->hfr_id = $request->id;
                $log->facility_status = "Not created due to network error";
                $log->user_id = Auth::user()->id;
                $log->save();
                return "Exception Error";
            }
        }
       
    }

    public function update(Request $request){
        $dhis = new HfrDhis;
        $id = $request->id;
        $data = $request->data;

        $uid = $dhis->getDhisFacilityUID($id);
        

        if(strlen($uid) == 11){
            try {
                $client = new Client([
                    'base_uri' =>  config('hfr.dhis_url')
                ]);
        
                $response = $client->put('organisationUnits/'. $uid, [
                    'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
                    'json' => $data['updates']
                ]);
                
                $status = $response->getReasonPhrase();
                if ($status == 'OK'){
                    $update_status = "Updated";
                }else{
                    $update_status = $status;
                }

    
                $ownership_status = 'No Updates';
                $level_status = 'No Updates';
                $level_option_status = 'No Updates';

                //if any of the organiation groups is updated
                if ($data['groups'] != 'empty'){
                 
                    foreach($data['groups'] as $key => $value) {
                        switch ($key) {
                            case "ownership_id":
                                $dhis->unAssignOwnership($value,$uid);
                                $ownership_status = $dhis->AssignOwnership($value,$uid);
                                break;
                            case "facility_level_id":
                                $dhis->unAssignLevelOfCare($value,$uid);
                                $level_status = $dhis->AssignLevelOfCare($value,$uid);
                                break;
                            case "facility_level_option_id":
                                if (in_array($value,[1,3,5])){ //1-Health post, 3-Primary Health Center, 5-Specialized Hospital
                                    $dhis->unAssignLevelOfCareOption($value,$uid);
                                    $level_option_status = $dhis->AssignLevelOfCareOption($value,$uid);
                                }       
                                break;
                        }
                    }
                }
    
                //Save status of actions
                $log = new DhisLog;
                $log->hfr_id = $id;
                $log->dhis_uid = $uid;
                $log->facility_status = $update_status;
                $log->ownership_status = $ownership_status;
                $log->level_status = $level_status;
                $log->level_option_status = $level_option_status;
                $log->user_id = Auth::user()->id;
                $log->save();

                
                //send notification email to dhis team
                $dhis->sendEmailtoDhisTeamForUpdatedFacility($data['facility_name'], $data['ward_id']);

                return 'Updated';               
    
            } catch (RequestException $e) {
                $log = new DhisLog;
                if ($e->hasResponse()) {
                    $response =  Psr7\str($e->getResponse());
                    $log->hfr_id = $id;
                    $log->facility_status = $response;
                    $log->user_id = Auth::user()->id;
                    $log->save();
                    return "Exception Error";
                }else {
                    $log->hfr_id = $id;
                    $log->facility_status = "Not updated due to network error";
                    $log->user_id = Auth::user()->id;
                    $log->save();
                    return "Exception Error";
                }
            }

        }else { // if failed to get facility uid from dhis
            $log = new DhisLog;
            $log->hfr_id = $id;
            $log->facility_status = $uid;
            $log->user_id = Auth::user()->id;
            $log->save();
            return "Exception Error";
        }
       
    }

  
    public function test(){
     
        $dhis = new HfrDhis;
        $data= $dhis->sendEmailtoDhisTeamForDeletedFacility('Fomalo Health Center','10014');
        dd($data);

        $client = new Client([
            'base_uri' =>  config('hfr.dhis_url')
        ]);

        $response = $client->get('organisationUnits?filter=code:eq:139556', [
            'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')]
        ]);
        $response;

        $array = json_decode($response->getBody()->getContents(), true); 

        if ($array['pager']['total'] > 0){
            $orgUnits = $array['organisationUnits'][0]['id'];
        }else{
            $orgUnits = 'None';
        }
    
        
        return $orgUnits;
    }


    public function logs(){
        $logs = DB::table('dhis_log_details')->paginate(100);

        return view('dhis.logs', compact("logs")); 
    }

    
}
