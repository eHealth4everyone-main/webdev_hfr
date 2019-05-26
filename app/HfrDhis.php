<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\User;
use Notification;
use App\Notifications\sendNewFacilityEmailtoDhisTeam;
use App\Notifications\sendUpdateFacilityEmailtoDhisTeam;
use App\Notifications\sendDeleteFacilityEmailtoDhisTeam;



class HfrDhis extends Model
{
    public function getParent($ward_id){
        $uid = $this->getWardUID($ward_id);
        
        $parent = [];
        $parent['id'] = $uid;

        return $parent;
    }

    public function getWardUID($ward_id){
        $ward = DB::table('dhis_lookup')
        ->select('dhis_uid')
        ->where('hfr_id',$ward_id)
        ->where('type','Ward')   
        ->get();

        return $ward[0]->dhis_uid;
    }

    //get the shortname for dhis, if the name is longer than 50, take 
    //first 50 char of the name. and if alt name is not supplied use name for shortname
    public function getShortname($name, $alt_name){
        if ($alt_name ==''){
            $shortname = $this->toDhisShortName($name);
        }
        else{
            $shortname = $this->toDhisShortName($alt_name);
        }
        return $shortname;
    }

    public function toDhisShortName($name){
        if(strlen($name) > 49){
            $shortname = substr($name,0,50);
        }else{
            $shortname = $name;
        }
        return $shortname;
    }

    public function formatName($name,$state_id){
        $code = DB::table('ou_states')
            ->select('short_code')
            ->where('id',$state_id)
            ->get();

        $shortcode = strtolower($code[0]->short_code);
        $facility_name = $shortcode. " ". $name;
        return $facility_name;
    }

    public function formatGeoCords($long, $lat){
        return '['. $long. ','. $lat . ']';
    }

    public function formatDate($date){
        if ($date == ''){
            return "";
        }else{
            return date('Y-m-d', strtotime($date));
        }
    }

    //ownership i.e. private and public
    public function assignOwnership($ownership_id,$orgUnit){      
        try{
            //get ownership uid
            $ownership = DB::table('dhis_lookup')
            ->select('dhis_uid')
            ->where('hfr_id',$ownership_id)
            ->where('type','Ownership')   
            ->get();

            $orgUnitGroup = $ownership[0]->dhis_uid;

            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);

            $response=$client->post('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
            ]);
            
            if ($response->getStatusCode() == '204'){
                return 'Assigned';
            }else{
                return 'Not Assigned';
            }
            
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());
            }else {
                return "Exception Error";
            }
        }
    }

    public function unAssignOwnership($ownership_id,$orgUnit){      
        try{
            //get ownership uid
            $ownership = DB::table('dhis_lookup')
            ->select('dhis_uid')
            ->where('hfr_id',$ownership_id)
            ->where('type','Ownership')   
            ->get();

            $orgUnitGroup = $ownership[0]->dhis_uid;

            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);
    
            $response=$client->delete('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
            ]);
            
            if ($response->getStatusCode() == '204'){
                return 'true';
            }else{
                return 'false';
            }
            
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());
            }else {
                return "Exception Error";
            }
        }
    }

    // level of care, Primary, Secodary & Tertiary
    public function assignLevelOfCare($levelId,$orgUnit){
        try{
            //get level of care uid
            $level = DB::table('dhis_lookup')
                    ->select('dhis_uid')
                    ->where('hfr_id',$levelId)
                    ->where('type','Level of Care')   
                    ->get();

            $orgUnitGroup = $level[0]->dhis_uid;
        
            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);

            $response=$client->post('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
            ]);

            if ($response->getStatusCode() == '204'){
                return 'Assigned';
            }else{
                return 'Not Assigned';
            }

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());               
            }else {
                return "Exception Error";
            }
        }
    }

    public function unAssignLevelOfCare($levelId,$orgUnit){
        try{
            //get level of care uid
            $level = DB::table('dhis_lookup')
                    ->select('dhis_uid')
                    ->where('hfr_id',$levelId)
                    ->where('type','Level of Care')   
                    ->get();

            $orgUnitGroup = $level[0]->dhis_uid;
        
            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);

            $response=$client->delete('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
            ]);

            if ($response->getStatusCode() == '204'){
                return 'true';
            }else{
                return 'false';
            }

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());               
            }else {
                return "Exception Error";
            }
        }
    }

    // Level of care option eg. Health Post, Primary Health Center etc.
    public function assignLevelOfCareOption($levelOptionId,$orgUnit){
        try{
            //get level of care option uid
            $levelOption = DB::table('dhis_lookup')
                    ->select('dhis_uid')
                    ->where('hfr_id',$levelOptionId)
                    ->where('type','Level of Care Option')   
                    ->get();

            $orgUnitGroup = $levelOption[0]->dhis_uid;
        
            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);

            $response=$client->post('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
            ]);

            if ($response->getStatusCode() == '204'){
                return 'Assigned';
            }else{
                return 'Not Assigned';
            }

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());               
            }else {
                return "Exception Error";
            }
        }
    
    }

    public function unAssignLevelOfCareOption($levelOptionId,$orgUnit){
        try{
            //get level of care option uid
            $levelOption = DB::table('dhis_lookup')
                    ->select('dhis_uid')
                    ->where('hfr_id',$levelOptionId)
                    ->where('type','Level of Care Option')   
                    ->get();

            $orgUnitGroup = $levelOption[0]->dhis_uid;
        
            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);
            
            $response=$client->delete('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')],
            ]);

            if ($response->getStatusCode() == '204'){
                return 'true';
            }else{
                return 'false';
            }

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());               
            }else {
                return "Exception Error";
            }
        }
    
    }

    public function getDhisFacilityUID($hfr_facility_id){      
        try{
            $client = new Client([
                'base_uri' =>  config('hfr.dhis_url')
            ]);
    
            $response = $client->get('organisationUnits?filter=code:eq:'. $hfr_facility_id , [
                'auth' => [config('hfr.dhis_username'),config('hfr.dhis_password')]
            ]);

    
            $array = json_decode($response->getBody()->getContents(), true); 
         
            if ($array['pager']['total'] > 0){
                $orgUnits = $array['organisationUnits'][0]['id'];
            }else{
                $orgUnits = 'Facility with id '. $hfr_facility_id. ' was not found in DHIS2' ;
            }
        
            return $orgUnits;

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response =  Psr7\str($e->getResponse());
                return $response;
            }else {
                return "Operation failed due to network error!";
            }
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
            $dataArray = [];
            
        
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
            $dataArray['facility_name'] = $hosp['facility_name'];
            $dataArray['ward_id'] = $hosp['ward_id'];
            
            if (count($orgUnitGroups) > 0){
                $dataArray['groups'] = $orgUnitGroups;
            }else{
                $dataArray['groups'] = 'empty';
            }

            return $dataArray;
            // $x = $this->sendUPdates($dataArray, $id);
            // return x;
        }else{
            return 'false';
        }

    }

    public function sendEmailtoDhisTeamForNewFacility($name,$ward_id){
        $ward = DB::table('wards')
                ->where('id',$ward_id)
                ->get();

        $state = $ward[0]->state;
        $lga = $ward[0]->lga;
        $ward_name = $ward[0]->name;

        $users = User::permission('Receive DHIS2 Notifications')->get();
        Notification::send($users, new sendNewFacilityEmailtoDhisTeam($name,$state,$lga,$ward_name));
    }

    public function sendEmailtoDhisTeamForUpdatedFacility($name,$ward_id){
        $ward = DB::table('wards')
                ->where('id',$ward_id)
                ->get();

        $state = $ward[0]->state;
        $lga = $ward[0]->lga;
        $ward_name = $ward[0]->name;

        $users = User::permission('Receive DHIS2 Notifications')->get();
        Notification::send($users, new sendUpdateFacilityEmailtoDhisTeam($name,$state,$lga,$ward_name));
    }

    public function sendEmailtoDhisTeamForDeletedFacility($name,$ward_id){
        $ward = DB::table('wards')
                ->where('id',$ward_id)
                ->get();

        $state = $ward[0]->state;
        $lga = $ward[0]->lga;
        $ward_name = $ward[0]->name;

        $users = User::permission('Receive DHIS2 Notifications')->get();
        Notification::send($users, new sendDeleteFacilityEmailtoDhisTeam($name,$state,$lga,$ward_name));
    }

    //temporary method, to be deleted
    public function sendUPdates($data, $id){
    
        $uid = $this->getDhisFacilityUID($id);
        
        // dd($data['updates'], $uid);

        if(strlen($uid) == 11){
            try {
                $client = new Client([
                    'base_uri' =>  env('DHIS_BASE_URI')
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

    
                //if any of the organiation groups is updated
                $ownership_status = 'No Updates';
                $level_status = 'No Updates';
                $level_option_status = 'No Updates';

                if (count($data['groups']) > 0){

                    foreach($data['groups'] as $key => $value) {
                        switch ($key) {
                            case "ownership_id":
                                $this->unAssignOwnership($value,$uid);
                                $ownership_status = $this->AssignOwnership($value,$uid);
                                break;
                            case "facility_level_id":
                                $this->unAssignLevelOfCare($value,$uid);
                                $level_status = $this->AssignLevelOfCare($value,$uid);
                                break;
                            case "facility_level_option_id":
                                if (in_array($value,[1,3,5])){
                                    $this->unAssignLevelOfCareOption($value,$uid);
                                    $level_option_status = $this->AssignLevelOfCareOption($value,$uid);
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
                $log->save();

                return 'Updated';               
    
            } catch (RequestException $e) {
                $log = new DhisLog;
                if ($e->hasResponse()) {
                    $response =  Psr7\str($e->getResponse());
                    $log->hfr_id = $id;
                    $log->facility_status = $response;
                    $log->save();
                    return "Exception Error";
                }else {
                    $log->hfr_id = $id;
                    $log->facility_status = "Not updated due to network error";
                    $log->save();
                    return "Exception Error";
                }
            }

        }else { // if failed to get facility uid from dhis
            $log = new DhisLog;
            $log->hfr_id = $id;
            $log->facility_status = $uid;
            $log->save();
            return "Exception Error";
        }
       
    }



}
