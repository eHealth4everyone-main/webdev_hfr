<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pharma;
use App\Signature;
use Illuminate\Support\Facades\DB;


class PharmaController extends Controller
{
     public function index()
    {
        $pharmas =DB::table('pharmacies')->get();
        return view('pharma.index', compact("pharmas"));
    }
    public function public_index()
    {
        $pharmas =DB::table('pharmacies')->get();
        return view('public.pharmacyList', compact("pharmas"));
    }


    public function create()
    {
        return view('pharma.create');        
    }

 
    public function store(Request $request)
    {
        $rules = [
            'sig_unique_id'=>'unique',
            'cac_reg'=>'nullable',
            'comm_date'=>'nullable|date',
            'reg_fac_name'=>'required',
            'alt_facility_name'=>'nullable',
            'state'=>'required',
            'lga'=>'required',
            'ward'=>'nullable',
            'house_no'=>'nullable',
            'street_name'=>'nullable',
            'longitude'=>'nullable',
            'latitude'=>'nullable',
            'postal_address'=>'nullable',
            'phone_number'=>'nullable',
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'hr_operation'=>'nullable',
            'operational_hours'=>'nullable',
            'hs_ownership'=>'required',
            'hs_op_status'=>'required',
            'standalone'=>'required',
            'ph_num_pharmacist'=>'numeric',
            'ph_num_pharm_tech'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            'standalone.required' => 'The Institution/Stand Alone field is required',
            
            'ph_num_pharm_tech.numeric' => 'The Number of Technicians field must be a number.',
            'ph_num_pharmacist.numeric' => 'The Number of Pharmacists field must be a number.'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $ph = new Pharma;
        
        $max = $sign::where('id','>', 1)->max('id');
        $ids = $max + 1; //auto increment id

        $num_of_fac = $sign::where('state',$request->state)
        ->where('lga',$request->lga)
        ->count();
        $num_of_fac = $num_of_fac + 1; //get serial number of the next HF in LGA
        
        $UniqueID = $sign->makeID($request->state,$request->lga,"2",$request->hs_level,$request->hs_ownership,$num_of_fac);
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        
        $opdays = $sign->arrayValuesTostring($request->operational_days);      
        
        $sign->id=$ids;
        $sign->sig_unique_id=$UniqueID;
        $sign->fac_tpye='2';
        $sign->cac_reg= $request->cac_reg;
        $sign->comm_date=$regdate;
        $sign->reg_fac_name= strtoupper($request->reg_fac_name);
        $sign->alt_facility_name = strtoupper($request->alt_facility_name);
        $sign->state = $request->state;
        $sign->lga = $request->lga;
        $sign->ward = $request->ward;
        $sign->house_no = $request->house_no;
        $sign->street_name = $request->street_name;
        $sign->longitude = $request->longitude;
        $sign->latitude = $request->latitude;
        $sign->postal_address = $request->postal_address;
        $sign->phone_number = $request->phone_number;
        $sign->email_address = $request->email_address;
        $sign->website = $request->website;
        $sign->operational_days = $opdays;
        $sign->hr_operation = $request->hr_operation;
        $sign->operational_hours = $request->operational_hours;
        $sign->save();
        
        $ph->ph_id = $ids;
        $ph->ph_hs_sig_id = "";
        $ph->ph_sig_unique_id = $UniqueID;
        $ph->standalone= $request->standalone;
        $ph->pharmacy_category= $request->pharmacy_category;
        $ph->ph_reg_no= $request->ph_reg_no;
        $ph->ph_op_status= $request->hs_op_status;
        $ph->ph_reg_status= $request->hs_reg_status;
        $ph->ph_lic_status= $request->hs_lic_status;
        $ph->ownership= $request->hs_ownership;
        $ph->ownership_type= $request->hs_ownership_type;
        $ph->ownership_detail= $request->hs_ownership_details;
        $ph->ph_num_pharmacist= $request->ph_num_pharmacist;
        $ph->ph_num_pharm_tech= $request->ph_num_pharm_tech;
        $ph->statecode = $request->state;
        $ph->ph_flag_old="No";
        $ph->ph_flag="0";
        $ph->save();
        
        session()->flash("alert-success", "Facility Information Saved Successfully!");
        return redirect()->back();
    }

    public function show($id)
    {
        $pharma =Signature::findorfail($id);
        return view('pharma.show', compact("pharma")); 
    }


    public function edit($id)
    {
        $pharma =Signature::findorfail($id);
        //dd($pharma);
        return view('pharma.edit', compact("pharma")); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'sig_unique_id'=>'unique',
            'cac_reg'=>'nullable',
            'comm_date'=>'nullable|date',
            'reg_fac_name'=>'required',
            'alt_facility_name'=>'nullable',
            'state'=>'required',
            'lga'=>'required',
            'ward'=>'nullable',
            'house_no'=>'nullable',
            'street_name'=>'nullable',
            'longitude'=>'nullable',
            'latitude'=>'nullable',
            'postal_address'=>'nullable',
            'phone_number'=>'nullable',
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'hr_operation'=>'nullable',
            'operational_hours'=>'nullable',
            'hs_ownership'=>'required',
            'hs_op_status'=>'required',
            'standalone'=>'required',
            'ph_num_pharmacist'=>'numeric',
            'ph_num_pharm_tech'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            'standalone.required' => 'The Institution/Stand Alone field is required',
            
            'ph_num_pharm_tech.numeric' => 'The Number of Technicians field must be a number.',
            'ph_num_pharmacist.numeric' => 'The Number of Pharmacists field must be a number.'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $ph = new Pharma;
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        
        $opdays = $sign->arrayValuesTostring($request->operational_days); 

        $sign=Signature::findOrFail($id);
        $sign->cac_reg= $request->cac_reg;
        $sign->comm_date=$regdate;
        $sign->reg_fac_name= strtoupper($request->reg_fac_name);
        $sign->alt_facility_name = strtoupper($request->alt_facility_name);
        $sign->state = $request->state;
        $sign->lga = $request->lga;
        $sign->ward = $request->ward;
        $sign->house_no = $request->house_no;
        $sign->street_name = $request->street_name;
        $sign->longitude = $request->longitude;
        $sign->latitude = $request->latitude;
        $sign->postal_address = $request->postal_address;
        $sign->phone_number = $request->phone_number;
        $sign->email_address = $request->email_address;
        $sign->website = $request->website;
        $sign->operational_days = $opdays;
        $sign->hr_operation = $request->hr_operation;
        $sign->operational_hours = $request->operational_hours;
        $sign->save();

        $ph=Pharma::findOrFail($id);
        $ph->ph_hs_sig_id = "";
        $ph->standalone= $request->standalone;
        $ph->pharmacy_category= $request->pharmacy_category;
        $ph->ph_reg_no= $request->ph_reg_no;
        $ph->ph_op_status= $request->hs_op_status;
        $ph->ph_reg_status= $request->hs_reg_status;
        $ph->ph_lic_status= $request->hs_lic_status;
        $ph->ownership= $request->hs_ownership;
        $ph->ownership_type= $request->hs_ownership_type;
        $ph->ownership_detail= $request->hs_ownership_details;
        $ph->ph_num_pharmacist= $request->ph_num_pharmacist;
        $ph->ph_num_pharm_tech= $request->ph_num_pharm_tech;
        $ph->statecode = $request->state;
        $ph->ph_flag_old="No";
        $ph->ph_flag="0";
        $ph->save();
        
        session()->flash("alert-success", "Record Updated Successfully!");
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
