<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;


class HfrDhisController extends Controller
{
    public function index(){

        $this->assignOwnership(1, 'vIJhwNGzTa2');
      
        // //--
        // $array = json_decode($response->getBody()->getContents(), true); // :'(
        // return $array;

        // return $array["shortName"];
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
            'shortName' => $request->alt_facility_name,
            'code' => '',
            'openingDate' => date('Y-m-d', strtotime($request->start_date)),
            // 'closedDate' =>"",
            'address' => $request->postal_address,
            'coordinates' => '['. $request->longitude. ','. $request->latitude . ']', //long,latitude
            'email' => $request->email_address,
            'url' => $request->website,
            'phoneNumber' => $request->phone_number,
            'parent' => $parent
        ];


        $client = new Client([
            'base_uri' =>  env('DHIS_BASE_URI')
        ]);

        $response = $client->post('organisationUnits', [
            'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')],
            'json' => $data
        ]);

        return $response;
        
    }

    public function test(){
        return view('dhis.index');
      
    }

    //ownership i.e. private and public
    public function assignOwnership($ownership_id,$orgUnit){
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
        
        return $response->getStatusCode();
    }

    // level of care, Primary, Secodary & Tertiary
    public function assignLevelOfCare($levelId,$orgUnit){
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
        
        return $response->getStatusCode();
    }

    // Level of care option eg. Health Post, Primary Health Center etc.
    public function assignLevelOfCareOption($levelOptionId,$orgUnit){
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
        
        return $response->getStatusCode();
    }

    
}
