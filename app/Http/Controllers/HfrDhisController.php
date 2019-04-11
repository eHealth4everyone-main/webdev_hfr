<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;


class HfrDhisController extends Controller
{
    public function index(){

      

        $client = new Client([
            'base_uri' => env('DHIS_BASE_URI')
        ]);

        $response = $client->get('organisationUnits/S2WOOQMDhz8', [
            'auth' => [env('DHIS_USERNAME'), env('DHIS_PASSWORD')]]);

      
        $array = json_decode($response->getBody()->getContents(), true); // :'(

        return $array;

        return $array["shortName"];
    }


    public function store(){

        $parent = DB::table('dhis_lookup')
            ->select('dhis_uid')
            ->where('hfr_id',old('ward_id'))
            ->where('type','Ward')   
            ->get();
 

        $data= [];
        
        $parent = ['id' => $parent[0]->dhis_uid];
     
        $data = [
            "name" =>old('facility_name'),
            'shortName' => old('alt_facility_name'),
            'code' => '',
            'openingDate' => date('Y-m-d', strtotime(old('start_date'))),
            // 'closedDate' =>"",
            'address' => old('postal_address'),
            'coordinates' => '['. old('longitude'). ','. old('latitude') . ']', //long,latitude
            'email' => old('email_address'),
            'url' => old('website'),
            'phoneNumber' => old('phone_number'),
            'parent' => $parent
        ];

        // return $data;

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
        dd(old('facility_name'));
      
    }



    
}
