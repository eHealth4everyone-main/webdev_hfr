<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityListingController extends Controller
{
   
    public function hosptials()
    {
        $facilities = DB::table('view_hospitals')->get();
        return view('public.hospitalList', compact("facilities"));
    }

    public function index(Request $request)
    {
       
        $type=0;

        if ($request->facilitytype==1){
            $facilities = DB::table('view_hospitals')->get();
            $type = 1;
        }

        if ($request->facilitytype==2){
            $facilities = DB::table('laboratory')->get();
            $type = 2;
        }
        if ($request->facilitytype==3){
            $facilities = DB::table('pharmacies')->get();
            $type = 3;
        }
        if ($request->facilitytype==4){
            $facilities = DB::table('radiologies')->get();
            $type = 4;
        }

        return view('public.faclist', compact("facilities","type"));
        
    
    }


  
}
