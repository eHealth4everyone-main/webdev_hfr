<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HospitalServiceController extends Controller
{
    public function index()
    {
        $services = DB::select('SELECT c.description, s.name FROM lst_hosp_services s JOIN lst_hosp_service_category c ON c.id=s.service_category_id');
    
        return view('hospitals.services.index',compact('services')); 
    }
       
}
