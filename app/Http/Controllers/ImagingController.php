<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imaging;
use App\Signature;
use Illuminate\Support\Facades\DB;

class ImagingController extends Controller
{

    public function index()
    {
        $imagings =DB::table('radiologies')->get();
        return view('imaging.index', compact("imagings"));
    }

    public function public_index()
    {
        $imagings =DB::table('radiologies')->get();
        return view('public.radiologyList', compact("imagings"));
    }
    public function create()
    {
        return view('imaging.create');
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
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'hr_operation'=>'nullable',
            'operational_hours'=>'nullable',
            'hs_ownership'=>'required',
            'hs_op_status'=>'required',
            'standalone'=>'required',
            'im_radiography_tech'=>'numeric',
            'im_radiographer'=>'numeric',
            'im_radiologist'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            'standalone.required' => 'The Institution/Stand Alone field is required',
            
            'im_radiologist.numeric' => 'The Number of Radiologist field must be a number.',
            'im_radiographer.numeric' => 'The Number of Radiographers field must be a number.',
            'im_radiography_tech.numeric'=>'The Number of Radiography Technicians field must be a number'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $im = new Imaging;
        
        $max = $sign::where('id','>', 1)->max('id');
        $ids = $max + 1; //auto increment id

        $num_of_fac = $sign::where('state',$request->state)
        ->where('lga',$request->lga)
        ->count();
        $num_of_fac = $num_of_fac + 1; //get serial number of the next HF in LGA
        
        $UniqueID = $sign->makeID($request->state,$request->lga,"4",$request->hs_level,$request->hs_ownership,$num_of_fac);
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        
        $opdays = $sign->arrayValuesTostring($request->operational_days);
        $services = $sign->arrayValuesTostring($request->services);      
        
        $sign->id=$ids;
        $sign->sig_unique_id=$UniqueID;
        $sign->fac_tpye='4';
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
        
        $im->im_id = $ids;
        $im->im_hs_sig_id = "";
        $im->im_sig_unique_id = $UniqueID;
        $im->im_state = $request->standalone;
        $im->im_regg_num= $request->im_regg_num;
        $im->im_service= $services;
        $im->im_owner= $request->hs_ownership;
        $im->im_owner_type= $request->hs_ownership_type;
        $im->im_detail= $request->hs_ownership_details;
        $im->im_radiologist= $request->im_radiologist;
        $im->im_radiographer= $request->im_radiographer;
        $im->im_radiography_tech= $request->im_radiography_tech;
        $im->statecode = $request->state;
        $im->im_flag_old="No";
        $im->im_op_status= $request->hs_op_status;
        $im->im_reg_status= $request->hs_reg_status;
        $im->im_lic_status= $request->hs_lic_status;
        $im->im_flag="0";
        $im->save();
        
        session()->flash("alert-success", "Radiology Facility Information Saved Successfully!");
        return redirect()->back();
    }

   
    public function show($id)
    {
        $imagings =Signature::findorfail($id);
        return view('imaging.show', compact("imagings"));
    }

    public function edit($id)
    {
        $imagings =Signature::findorfail($id);
        return view('imaging.edit', compact("imagings"));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'sig_unique_id'=>'unique',
            'comm_date'=>'nullable|date',
            'reg_fac_name'=>'required',
            'state'=>'required',
            'lga'=>'required',
            'email_address'=>'nullable|email',
            'hs_ownership'=>'required',
            'hs_op_status'=>'required',
            'standalone'=>'required',
            'im_radiography_tech'=>'numeric',
            'im_radiographer'=>'numeric',
            'im_radiologist'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            'standalone.required' => 'The Institution/Stand Alone field is required',
            
            'im_radiologist.numeric' => 'The Number of Radiologist field must be a number.',
            'im_radiographer.numeric' => 'The Number of Radiographers field must be a number.',
            'im_radiography_tech.numeric'=>'The Number of Radiography Technicians field must be a number'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $im = new Imaging;
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        
        $opdays = $sign->arrayValuesTostring($request->operational_days);
        $services = $sign->arrayValuesTostring($request->services);  

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
        
        $im=Imaging::findOrFail($id);
        $im->im_hs_sig_id = "";
        $im->im_state = $request->standalone;
        $im->im_regg_num= $request->im_regg_num;
        $im->im_service= $services;
        $im->im_owner= $request->hs_ownership;
        $im->im_owner_type= $request->hs_ownership_type;
        $im->im_detail= $request->hs_ownership_details;
        $im->im_radiologist= $request->im_radiologist;
        $im->im_radiographer= $request->im_radiographer;
        $im->im_radiography_tech= $request->im_radiography_tech;
        $im->statecode = $request->state;
        $im->im_flag_old="No";
        $im->im_op_status= $request->hs_op_status;
        $im->im_reg_status= $request->hs_reg_status;
        $im->im_lic_status= $request->hs_lic_status;
        $im->im_flag="0";
        $im->save();
        
        session()->flash("alert-success", "Record Updated Successfully!");
        return redirect()->back();
    }

  
    public function destroy($id)
    {
        //
    }

    public function fetchServices(Request $request)
    {
        $data = DB::table('tbl_imaging_service')
                ->select('im_service_id','im_service_name')     
                ->get();

        $output = '<option value="">Select Certification </option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->im_service_id.'">'.$row->im_service_name.'</option>';
        }
        return $output;
    }
}
