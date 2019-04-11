<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class HfrDhisController extends Controller
{
    public function index(){

        $client = new Client([
            'base_uri' => 'https://play.dhis2.org/2.31dev/api/29/'
        ]);

        $response = $client->get('organisationUnits/Rp268JB6Ne4', ['auth' => ['admin', 'district']]);

      
        $array = json_decode($response->getBody()->getContents(), true); // :'(
        
        return $array["shortName"];
    }


    public function store(){

        $data= [];
        
        $parent = ['id' => "YuQRtpLP10I"];
     
        $data = [
            "name" =>"Kumaija HC",
            'shortName' => "KHC",
            'openingDate' => "2019-03-12",
            'closedDate' =>"",
            'address' => "397 Old Lane",
            'coordinates' => "[2.96158,2.46073]",
            'email' => "donyh@mailinator.net",
            'url' => "https://www.google.com",
            'phoneNumber' => "+884-39-9548987",
            'parent' => $parent
        ];

        // return $data;

        $client = new Client([
            'base_uri' => 'https://play.dhis2.org/2.31dev/api/29/'
        ]);

        
        $response = $client->post('organisationUnits', [
            'auth' => ['admin', 'district'],
            'json' => $data
        ]);

        return $response;
        
    }


    
}
