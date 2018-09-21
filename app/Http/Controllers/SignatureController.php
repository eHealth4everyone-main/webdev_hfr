<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Signature;
use App\Hospital;

class SignatureController extends Controller
{
    
    public function index()
    {
        // $signatures =Signature::where('fac_tpye',1)->get();
        // return view('sign.index', compact("signatures"));
      
        $facilities = DB::table('view_hospitals')->get();
        return view('sign.index', compact("facilities"));
    }
       
  
    public function create()
    {
        return view('sign.create');
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
            'hs_level'=>'required',
            'hs_ownership'=>'required',
            'hs_op_status'=>'required',
            
            'hs_inpatient_acc_and_emg_num'=>'numeric',
            'hs_inpatient_adm_fac_num'=>'numeric',
            'hs_inpatient_int_care_service_num'=>'numeric',
            'hs_no_doctors'=>'numeric',
            'hs_no_single_qualified_nurses'=>'numeric',
            'hs_no_single_qualified_midwives'=>'numeric',
            'hs_nurses_midwives'=>'numeric',
            'hs_no_pharm'=>'numeric',
            'hs_no_lab_sc'=>'numeric',
            'hs_no_dentist'=>'numeric',
            'hs_no_comm_health_officer'=>'numeric',
            'hs_no_comm_health_ext_officer'=>'numeric',
            'hs_no_jun_comm_health_ext_off'=>'numeric',
            'hs_no_env_health_officer'=>'numeric',
            'hs_no_lab_tech'=>'numeric',
            'hs_no_health_rec'=>'numeric',
            'hs_no_pharm_tech'=>'numeric',
            'hs_no_dental_tech'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_level.required' => 'The Hospital level field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            
            'hs_inpatient_acc_and_emg_num.numeric' => 'The Number of Beds field must be a number.',
            'hs_inpatient_adm_fac_num.numeric' => 'The Number of Beds field must be a number.',
            'hs_inpatient_int_care_service_num.numeric' => 'The Number of Beds field must be a number.',
            'hs_no_doctors.numeric' => 'Medical Doctors field must be a number.',
            'hs_no_single_qualified_nurses.numeric' => 'The Nurses(Single) field must be a number.',
            'hs_no_single_qualified_midwives.numeric' => 'The Midwifes(Single) field must be a number.',
            'hs_nurses_midwives.numeric' => 'The Nurse/Midwife(Double) field must be a number.',
            'hs_no_pharm.numeric' => 'The Pharmacy field must be a number.',
            'hs_no_lab_sc.numeric' => 'The Laboratory Scientists field must be a number.',
            'hs_no_dentist.numeric' => 'The Dentists field must be a number.',
            'hs_no_comm_health_officer.numeric' => 'The Community Health Officer field must be a number.',
            'hs_no_comm_health_ext_officer.numeric' => 'The Community Health Extension Worker field must be a number.',
            'hs_no_jun_comm_health_ext_off.numeric' => 'The Junior Com Health Extension Worker field must be a number.',
            'hs_no_env_health_officer.numeric' => 'The Environmental Health Officers field must be a number.',
            'hs_no_lab_tech.numeric' => 'The Laboratory Technicians field must be a number.',
            'hs_no_health_rec.numeric' => 'The Health Records/HIM Officers field must be a number.',
            'hs_no_pharm_tech.numeric' => 'The Pharmacy Technicians field must be a number.',
            'hs_no_dental_tech.numeric' => 'The Dental Technicians field must be a number.'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $hosp = new Hospital;
        
        $max = $sign::where('id','>', 1)->max('id');
        $ids = $max + 1; //auto increment id
        $num_of_fac = $sign::where('state',$request->state)
        ->where('lga',$request->lga)
        ->count();
        $num_of_fac = $num_of_fac + 1; //get serial number of the next HF in LGA
        
        $UniqueID = $sign->makeID($request->state,$request->lga,"1",$request->hs_level,$request->hs_ownership,$num_of_fac);
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        
        $medical = $sign->arrayValuesTostring($request->medicals);
        $surgical = $sign->arrayValuesTostring($request->surgicals);
        $obsgyna = $sign->arrayValuesTostring($request->obs);
        $pediat = $sign->arrayValuesTostring($request->Pediatrics);
        $dental = $sign->arrayValuesTostring($request->dentals);
        $opdays = $sign->arrayValuesTostring($request->operational_days);
        $specificlincal = $sign->arrayValuesTostring($request->clinical);
        
        
        
        $sign->id=$ids;
        $sign->sig_unique_id=$UniqueID;
        $sign->fac_tpye='1';
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
        
        $hosp->hs_id = $ids;
        $hosp->hs_level = $request->hs_level;
        $hosp->hs_sig_unique_id = $UniqueID;
        $hosp->hs_level_option = $request->hs_level_option;
        $hosp->hs_sp_option = $request->hs_sp_option;
        $hosp->hs_ownership = $request->hs_ownership;
        $hosp->hs_ownership_type = $request->hs_ownership_type;
        $hosp->hs_ownership_details = $request->hs_ownership_details;
        $hosp->hs_op_status = $request->hs_op_status;
        $hosp->hs_reg_status = $request->hs_reg_status;
        $hosp->hs_lic_status = $request->hs_lic_status;
        $hosp->hs_service_type_outpatient = $request->opd;
        $hosp->hs_service_type_inpatient = $request->ipd;
        $hosp->hs_outpatient_medical = $medical;
        $hosp->hs_outpatient_surgery = $surgical;
        $hosp->hs_outpatient_obstetrics = $obsgyna;
        $hosp->hs_outpatient_pediatrics = $pediat;
        $hosp->hs_outpatient_dental = $dental;
        $hosp->hs_inpatient_acc_and_emg= $request->hs_inpatient_acc_and_emg;
        $hosp->hs_inpatient_acc_and_emg_num= $request->hs_inpatient_acc_and_emg_num;
        $hosp->hs_inpatient_adm_fac= $request->hs_inpatient_adm_fac;
        $hosp->hs_inpatient_adm_fac_num = $request->hs_inpatient_adm_fac_num;
        $hosp->hs_inpatient_int_care_service = $request->hs_inpatient_int_care_service;
        $hosp->hs_inpatient_int_care_service_num = $request->hs_inpatient_int_care_service_num;
        $hosp->hs_specific_clinical_services = $specificlincal;
        $hosp->hs_no_doctors = $request->hs_no_doctors;
        $hosp->hs_no_single_qualified_nurses = $request->hs_no_single_qualified_nurses;
        $hosp->hs_no_single_qualified_midwives = $request->hs_no_single_qualified_midwives;
        $hosp->hs_nurses_midwives = $request->hs_nurses_midwives;
        $hosp->hs_no_pharm = $request->hs_no_pharm;
        $hosp->hs_no_lab_sc = $request->hs_no_lab_sc;
        $hosp->hs_no_dentist = $request->hs_no_dentist;
        $hosp->hs_no_comm_health_officer = $request->hs_no_comm_health_officer;
        $hosp->hs_no_comm_health_ext_officer = $request->hs_no_comm_health_ext_officer;
        $hosp->hs_no_jun_comm_health_ext_off= $request->hs_no_jun_comm_health_ext_off;
        $hosp->hs_onsite_pharm= $request->hs_onsite_pharm;
        $hosp->hs_onsite_lab= $request->hs_onsite_lab;
        $hosp->hs_onsite_radio= $request->hs_onsite_radio;
        $hosp->hs_mort_service= $request->hs_mort_service;
        $hosp->hs_dhis_ident= $request->hs_dhis_ident;
        $hosp->hs_datim_ident= $request->hs_datim_ident;
        $hosp->hs_lmis_ident= $request->hs_lmis_ident;
        $hosp->hs_hris_ident= $request->hs_hris_ident;
        $hosp->hs_ennrims_ident= $request->hs_ennrims_ident;
        $hosp->hs_no_env_health_officer= $request->hs_no_env_health_officer;
        $hosp->hs_no_lab_tech = $request->hs_no_lab_tech;
        $hosp->hs_no_health_rec= $request->hs_no_health_rec;
        $hosp->hs_no_pharm_tech= $request->hs_no_pharm_tech;
        $hosp->hs_no_dental_tech= $request->hs_no_dental_tech;
        $hosp->statecode = $request->state;
        $hosp->hs_flag_old="No";
        $hosp->hs_flag="0";
        $hosp->save();
        
        session()->flash("alert-success", "Facility Informations Saved Successfully!");
        return redirect()->back();
        
    }
    
    public function fetchLga(Request $request){
        $data = DB::table('tbl_lga')
        ->select('lga','lga_id')
        ->where('state_id', $request->id)
        ->groupBy('lga','lga_id')
        ->get();
        
        $output = '<option value="">Select LGA </option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->lga_id.'">'.$row->lga.'</option>';
        }
        return $output;
    }
    public function fetchWards(Request $request){
        $data = DB::table('tbl_ward')
        ->select('ward','wd_id')
        ->where('lga_id', $request->lgaId)
        ->where('state_id', $request->stateId)
        ->groupBy('ward','wd_id')
        ->get();
    
        $output = '<option value="">Select Ward </option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->wd_id.'">'.$row->ward.'</option>';
        }
        return $output;
    }
    
    
    public function show($id)
    {
        $hosp =Signature::findorfail($id);
        // dd($hosp);
        return view('sign.show', compact("hosp"));   
    }
    
    
    public function edit($id)
    {
        $hosp =Signature::findorfail($id);
        return view('sign.edit', compact("hosp"));   
    }
    
  
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
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'hr_operation'=>'nullable',
            'operational_hours'=>'nullable',
            'hs_level'=>'required',
            'hs_ownership'=>'required',
            'hs_op_status'=>'required',
            
            'hs_inpatient_acc_and_emg_num'=>'numeric',
            'hs_inpatient_adm_fac_num'=>'numeric',
            'hs_inpatient_int_care_service_num'=>'numeric',
            'hs_no_doctors'=>'numeric',
            'hs_no_single_qualified_nurses'=>'numeric',
            'hs_no_single_qualified_midwives'=>'numeric',
            'hs_nurses_midwives'=>'numeric',
            'hs_no_pharm'=>'numeric',
            'hs_no_lab_sc'=>'numeric',
            'hs_no_dentist'=>'numeric',
            'hs_no_comm_health_officer'=>'numeric',
            'hs_no_comm_health_ext_officer'=>'numeric',
            'hs_no_jun_comm_health_ext_off'=>'numeric',
            'hs_no_env_health_officer'=>'numeric',
            'hs_no_lab_tech'=>'numeric',
            'hs_no_health_rec'=>'numeric',
            'hs_no_pharm_tech'=>'numeric',
            'hs_no_dental_tech'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_level.required' => 'The Hospital level field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            
            'hs_inpatient_acc_and_emg_num.numeric' => 'The Number of Beds field must be a number.',
            'hs_inpatient_adm_fac_num.numeric' => 'The Number of Beds field must be a number.',
            'hs_inpatient_int_care_service_num.numeric' => 'The Number of Beds field must be a number.',
            'hs_no_doctors.numeric' => 'Medical Doctors field must be a number.',
            'hs_no_single_qualified_nurses.numeric' => 'The Nurses(Single) field must be a number.',
            'hs_no_single_qualified_midwives.numeric' => 'The Midwifes(Single) field must be a number.',
            'hs_nurses_midwives.numeric' => 'The Nurse/Midwife(Double) field must be a number.',
            'hs_no_pharm.numeric' => 'The Pharmacy field must be a number.',
            'hs_no_lab_sc.numeric' => 'The Laboratory Scientists field must be a number.',
            'hs_no_dentist.numeric' => 'The Dentists field must be a number.',
            'hs_no_comm_health_officer.numeric' => 'The Community Health Officer field must be a number.',
            'hs_no_comm_health_ext_officer.numeric' => 'The Community Health Extension Worker field must be a number.',
            'hs_no_jun_comm_health_ext_off.numeric' => 'The Junior Com Health Extension Worker field must be a number.',
            'hs_no_env_health_officer.numeric' => 'The Environmental Health Officers field must be a number.',
            'hs_no_lab_tech.numeric' => 'The Laboratory Technicians field must be a number.',
            'hs_no_health_rec.numeric' => 'The Health Records/HIM Officers field must be a number.',
            'hs_no_pharm_tech.numeric' => 'The Pharmacy Technicians field must be a number.',
            'hs_no_dental_tech.numeric' => 'The Dental Technicians field must be a number.'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $hosp = new Hospital;
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        
        $medical = $sign->arrayValuesTostring($request->medicals);
        $surgical = $sign->arrayValuesTostring($request->surgicals);
        $obsgyna = $sign->arrayValuesTostring($request->obs);
        $pediat = $sign->arrayValuesTostring($request->Pediatrics);
        $dental = $sign->arrayValuesTostring($request->dentals);
        $opdays = $sign->arrayValuesTostring($request->operational_days);
        $specificlincal = $sign->arrayValuesTostring($request->clinical);
        
        
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
        
        $hosp=Hospital::findOrFail($id);
        $hosp->hs_level = $request->hs_level;
        $hosp->hs_level_option = $request->hs_level_option;
        $hosp->hs_sp_option = $request->hs_sp_option;
        $hosp->hs_ownership = $request->hs_ownership;
        $hosp->hs_ownership_type = $request->hs_ownership_type;
        $hosp->hs_ownership_details = $request->hs_ownership_details;
        $hosp->hs_op_status = $request->hs_op_status;
        $hosp->hs_reg_status = $request->hs_reg_status;
        $hosp->hs_lic_status = $request->hs_lic_status;
        $hosp->hs_service_type_outpatient = $request->opd;
        $hosp->hs_service_type_inpatient = $request->ipd;
        $hosp->hs_outpatient_medical = $medical;
        $hosp->hs_outpatient_surgery = $surgical;
        $hosp->hs_outpatient_obstetrics = $obsgyna;
        $hosp->hs_outpatient_pediatrics = $pediat;
        $hosp->hs_outpatient_dental = $dental;
        $hosp->hs_inpatient_acc_and_emg= $request->hs_inpatient_acc_and_emg;
        $hosp->hs_inpatient_acc_and_emg_num= $request->hs_inpatient_acc_and_emg_num;
        $hosp->hs_inpatient_adm_fac= $request->hs_inpatient_adm_fac;
        $hosp->hs_inpatient_adm_fac_num = $request->hs_inpatient_adm_fac_num;
        $hosp->hs_inpatient_int_care_service = $request->hs_inpatient_int_care_service;
        $hosp->hs_inpatient_int_care_service_num = $request->hs_inpatient_int_care_service_num;
        $hosp->hs_specific_clinical_services = $specificlincal;
        $hosp->hs_no_doctors = $request->hs_no_doctors;
        $hosp->hs_no_single_qualified_nurses = $request->hs_no_single_qualified_nurses;
        $hosp->hs_no_single_qualified_midwives = $request->hs_no_single_qualified_midwives;
        $hosp->hs_nurses_midwives = $request->hs_nurses_midwives;
        $hosp->hs_no_pharm = $request->hs_no_pharm;
        $hosp->hs_no_lab_sc = $request->hs_no_lab_sc;
        $hosp->hs_no_dentist = $request->hs_no_dentist;
        $hosp->hs_no_comm_health_officer = $request->hs_no_comm_health_officer;
        $hosp->hs_no_comm_health_ext_officer = $request->hs_no_comm_health_ext_officer;
        $hosp->hs_no_jun_comm_health_ext_off= $request->hs_no_jun_comm_health_ext_off;
        $hosp->hs_onsite_pharm= $request->hs_onsite_pharm;
        $hosp->hs_onsite_lab= $request->hs_onsite_lab;
        $hosp->hs_onsite_radio= $request->hs_onsite_radio;
        $hosp->hs_mort_service= $request->hs_mort_service;
        $hosp->hs_dhis_ident= $request->hs_dhis_ident;
        $hosp->hs_datim_ident= $request->hs_datim_ident;
        $hosp->hs_lmis_ident= $request->hs_lmis_ident;
        $hosp->hs_hris_ident= $request->hs_hris_ident;
        $hosp->hs_ennrims_ident= $request->hs_ennrims_ident;
        $hosp->hs_no_env_health_officer= $request->hs_no_env_health_officer;
        $hosp->hs_no_lab_tech = $request->hs_no_lab_tech;
        $hosp->hs_no_health_rec= $request->hs_no_health_rec;
        $hosp->hs_no_pharm_tech= $request->hs_no_pharm_tech;
        $hosp->hs_no_dental_tech= $request->hs_no_dental_tech;
        $hosp->statecode = $request->state;
        $hosp->save();
        
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
    
    public function search(Request $request)
    {
        return "dfdafd";
        
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            
            if($query != '')
            {
                $data = Signature::where('reg_fac_name','LIKE',"%{$query}%")
                ->orderBy('reg_fac_name', 'asc')
                ->get();
                
            }
            else
            {
                $data = Signature::all()
                ->orderBy('state', 'asc')
                ->get();
                
            }
            
            $total_row = $data->count();
            
            if($total_row > 0)
            {
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                    <td>'.$row->sig_unique_id.'</td>
                    <td>'.$row->reg_fac_name.'</td>
                    <td>'.$row->state.'</td>
                    <td>'.$row->lga.'</td>
                    <td>
                    <a href="#">
                    <button class="btn btn-info btn-sm"  type="button">Details</button>
                    </a>
                    <a href="#">
                    <button class="btn btn-primary btn-sm"  type="button" > Edit</button>
                    </a>
                    </td>
                    </tr>';
                }
            }
            else
            {
                $output = '
                <tr>
                <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            dd($data);
            echo json_encode($data);
        }
    }
}
