<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    public function getLgaList(Request $request){
        $data = DB::table('ou_lgas')
        ->select('name','id')
        ->where('state_id', $request->id)
        ->orderByRaw('name')
        ->get();
        
        $output = '<option value="">Select LGA </option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        return $output;
    }

    public function getWardList(Request $request){
        $data = DB::table('ou_wards')
        ->select('name','id')
        ->where('lga_id', $request->lga_id)
        ->orderByRaw('name')
        ->get();
    
        $output = '<option value="">Select Ward </option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
        }
        return $output;
    }
}
