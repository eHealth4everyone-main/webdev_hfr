<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Download;
use Illuminate\Support\Facades\DB;

class DownloadController extends Controller
{
    public function index (){
        $indx='1';
        $facilities = DB::table('hospitals_details')->get();
        return view('public.download_export',compact("indx"));
    }
    
    public function getFacilities(Request $request){
        $type = 0;
        $indx='0';
        $state = $request->state;
        $condition = '';

        if ($state == 0){
            $condition = '<>';
        }
        else{
            $condition = '=';
        }
      

        if ($request->facilitytype==1){
            $facilities = DB::table('hospitals_details')
                            ->where('state_id', $condition, $state)
                            ->get();
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

        return view('public.download_export', compact("facilities","type","indx"));
    }
    public function DownloadForm()
    {
        return view('public.download');
    }

    public function store(Request $request)
        {
            $request->validate([
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
                'organisation' => 'nullable|string|max:100',
                'country' => 'required',
                'designation' => 'required',
                'country' => 'required',
                'purpose' => 'required|max:200',
                'email' => 'required|string|email|max:100',
                'g-recaptcha-response' => 'required|captcha',
            ]);

            Download::create($request->all());

            session()->flash("alert-success", "Download successfully!");
            return back();
    }
}
