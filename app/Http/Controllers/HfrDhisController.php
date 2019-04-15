<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use App\DhisLog;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class HfrDhisController extends Controller
{
    public function index(){
        return view('dhis.index');    
    }

    public function store(Request $request){

        $parent = DB::table('dhis_lookup')
            ->select('dhis_uid')
            ->where('hfr_id',$request->ward_id)
            ->where('type','Ward')   
            ->get();
 
        $parent = ['id' => $parent[0]->dhis_uid];

        $data= [];
        
        $data = [
            'name' =>$request->facility_name,
            'shortName' => $this->getShortname($request->facility_name,$request->alt_facility_name),
            'code' => '',
            'openingDate' => date('Y-m-d', strtotime($request->start_date)),
            'closedDate' =>'',
            'address' => $request->postal_address,
            'coordinates' => '['. $request->longitude. ','. $request->latitude . ']', //long,latitude
            'email' => $request->email_address,
            'url' => $request->website,
            'phoneNumber' => $request->phone_number,
            'parent' => $parent
        ];


        try {
            $client = new Client([
                'base_uri' =>  env('DHIS_BASE_URI')
            ]);
    
            $response = $client->post('organisationUnits', [
                'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
                'json' => $data
            ]);

            if ($response->getReasonPhrase() ==  'Created'){
                $array = json_decode($response->getBody()->getContents(), true); 
                $facility_id = $array['response']['uid'];
    
                //Assign Organisation unit - ownership
                $ownership_status= $this->assignOwnership($request->ownership_id,$facility_id);

                //Assign Organisation unit - Level of Care
                $level_status = $this->assignLevelOfCare($request->facility_level_id, $facility_id);
       
                //Assign Organisation unit - Level of Care Options
                if (in_array($request->facility_level_id,[1,3,5])){
                    $level_option_status = $this->assignLevelOfCareOption($request->facility_level_option_id,$facility_id);
                }
                else{
                    $level_option_status = 'Not Supplied - Not Assigned';
                }
    
                //Save status of actions
                $log = new DhisLog;
                $log->hfr_id = '';
                $log->dhis_uid = $facility_id;
                $log->facility_status = 'Created';
                $log->ownership_status = $ownership_status;
                $log->level_status = $level_status;
                $log->level_option_status = $level_option_status;
                $log->save();
    
                return 'Created';
            }
            

        } catch (RequestException $e) {
            $log = new DhisLog;
            if ($e->hasResponse()) {
                $response =  Psr7\str($e->getResponse());
                $log->hfr_id = '12';
                $log->facility_status = $response;
                $log->save();
                return "Exception Error";
            }else {
                $log->hfr_id = '12';
                $log->facility_status = "Network Error";
                $log->save();
                return "Exception Error";
            }
        }
       
    }

    //get the shortname for dhis, if the name is longer than 50, take 
    //first 50 char of the name. and 
    //if alt name is not supplied use name for shortname
    public function getShortname($name, $alt_name){
        $shortname='';

        if ($alt_name ==''){
            if(strlen($name) > 49){
                $shortname = substr($name,0,50);
            }else{
                $shortname = $name;
            }
        }
        else{
            if(strlen($alt_name) > 49){
                $shortname = substr($alt_name,0,50);
            }else{
                $shortname = $alt_name;
            }
        }
        return $shortname;
    }

    public function test(){
        $client = new Client;
        try {
            $client->get('http://google.com/nosuchpage3');    
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response =  Psr7\str($e->getResponse());

                $log = new DhisLog;
                $log->hfr_id = '12';
                $log->dhis_uid = '55555555';
                $log->facility_status = $response;
                $log->save();
                return $response;
            }else {
                return "Network Error";
            }
        }

        // $client = new Client([
        //     'base_uri' =>  env('DHIS_BASE_URI')
        // ]);

        // $response = $client->get('organisationUnits/VUXLnlv5DDa', [
        //     'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')]
        // ]);

        // $array = json_decode($response->getBody()->getContents(), true); 
        // return $array;

        // return $array['parent']['id'];
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

    public function logs(){
        $logs = DhisLog::orderby('updated_at','desc')
                ->paginate(20);

        return view('dhis.logs', compact("logs")); 
    }

    
}
