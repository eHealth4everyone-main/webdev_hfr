<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacilityController extends Controller
{
    //
    public function listhospital(){
        return view("facilities.hospital");
    }
    public function listimaging(){
        return view("facilities.imaging");
    }
    public function listpharma(){
        return view("facilities.pharmaceutical");
    }
    public function listlab(){
        return view("facilities.lab");
    }


}
