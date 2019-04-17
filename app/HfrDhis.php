<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

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
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);
    
            $response=$client->post('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
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
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);
    
            $response=$client->delete('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
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
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);

            $response=$client->post('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
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
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);

            $response=$client->delete('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
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
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);

            $response=$client->post('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
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
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);

            $response=$client->delete('organisationUnitGroups/'. $orgUnitGroup .'/organisationUnits/'. $orgUnit, [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
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
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);
    
            $response = $client->get('organisationUnits?filter=code:eq:'. $hfr_facility_id , [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')]
            ]);
            
    
    
            $array = json_decode($response->getBody()->getContents(), true); 
         
            if ($array['pager']['total'] > 0){
                $orgUnits = $array['organisationUnits'][0]['id'];
            }else{
                $orgUnits = 'None';
            }
        
            return $orgUnits;
        } catch (RequestException $e) {
            return "Error";
        }
    }

    public function sendUpdatesToDHIS($data,$id){      
        try{
            $client = new Client([
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);
            
            $uid = $this->getDhisFacilityUID($id);
            
            if($uid != 'None'){
                // $response = $client->put('organisationUnits/'. $uid, [
                //     'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
                //     'json' => $data['updates']
                // ]);

                if (count($data['groups']) > 0){
                    
                    foreach($data['groups'] as $key => $value) {
                        switch ($key) {
                            case "ownership_id":
                                echo "owneship '<br>";
                                echo $this->unAssignOwnership($value,$uid);
                                echo '<br>';  
                                echo $this->AssignOwnership($value,$uid);
                                echo '<br>';                         
                                break;
                            case "facility_level_id":
                                echo "LOC '<br>";
                                echo $this->unAssignLevelOfCare($value,$uid);
                                echo '<br>';  
                                echo $this->AssignLevelOfCare($value,$uid);
                                echo '<br>';                      
                                break;
                            case "facility_level_option_id":
                                if (in_array($value,[1,3,5])){
                                    echo "LOCO '<br>";
                                    echo $this->unAssignLevelOfCareOption($value,$uid);
                                    echo '<br>';  
                                    echo $this->AssignLevelOfCareOption($value,$uid);
                                    echo '<br>';  
                                }           
                                break;
                        }
                        
                    }
                }

               dd('ok');

                // return $response->getReasonPhrase();
            }else{
                return 'Can not find facility with HFR id ' .$id. ' in DHIS2!';
            }
         
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return Psr7\str($e->getResponse());               
            }else {
                return "Exception Error";
            }
        }
    }
    
}
