<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\hs_hospital;

class HospitalsController extends Controller
{
    
    public function index()
    {
        $facilities = DB::table('hospital_details')
        ->select('state','lga','ward','unique_id','facility_name','facility_level','ownership','id')
        ->orderByRaw('state','lga','facility_name')
        ->paginate(15);
        //get state list
        
        $lst_states = Cache::remember('lst_states', 60, function () {
        return DB::table('ou_states')
                ->select('id','name')
                ->orderByRaw('name ASC')
                ->get();
        });
        return view('hospitals.index',compact('facilities','lst_states')); 
    }
       
  
    public function create()
    {
        //get state list
        $lst_states = Cache::remember('lst_states', 60, function () {
        return DB::table('ou_states')
                ->select('id','name')
                ->orderByRaw('name ASC')
                ->get();
        });

        //get facility types
        $lst_level_of_care = Cache::remember('lst_level_of_care', 60, function () {
            return DB::table('lst_level_of_care')
                    ->select('id','name')
                    ->get();
        });
        //get ownership
        $lst_ownerships= Cache::remember('lst_ownerships', 60, function () {
            return DB::table('lst_ownerships')
                    ->select('id','name')
                    ->get();
        });
        //get opertion statuss
        $lst_oparational_status= Cache::remember('lst_oparational_status', 60, function () {
            return DB::table('lst_oparational_status')
                    ->select('id','status')
                    ->where('category','1')
                    ->get();
        });
            //get regulatory statuss
            $lst_regulatory_status= Cache::remember('lst_regulatory_status', 60, function () {
            return DB::table('lst_regulatory_status')
                    ->select('id','status')
                    ->get();
        });
        //get license statuss
        $lst_license_status= Cache::remember('lst_license_status', 60, function () {
            return DB::table('lst_license_status')
                    ->select('id','status')
                    ->get();
        });
        
        return view('hospitals.create',compact('facilities','lst_level_of_care','lst_states','lst_ownerships','lst_oparational_status',
        'lst_regulatory_status','lst_license_status')); 
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'registration_no'=>'nullable',
            'start_date'=>'nullable|date',
            'facility_name'=>'required|max:200',
            'alt_facility_name'=>'nullable|max:200',
            'state_id'=>'required',
            'lga_id'=>'required',
            'ward_id'=>'required',
            'ownership_id'=>'required',
            'ownership_type_id'=>'required',
            'ownership_details'=>'nullable',
            'facility_level_id'=>'required',
            'facility_level_option_id'=>'nullable',
            'house_no'=>'nullable',
            'street_name'=>'nullable',
            'longitude'=>'nullable',
            'latitude'=>'nullable',
            'postal_address'=>'nullable',
            'phone_number'=>'nullable',
            'email_address'=>'nullable|email',
            'website'=>'nullable',
            'operational_days'=>'nullable',
            'operational_hours'=>'nullable',
            'operational_status_id'=>'required',
            'regulatory_status_id'=>'nullable',
            'license_status_id'=>'nullable',
            'doctors'=>'nullable|numeric',
            'pharmacists'=>'nullable',
            'pharmacy_technicians'=>'nullable|numeric',
            'nurses'=>'nullable|numeric',
            'lab_scientists'=>'nullable|numeric',
            'midwifes'=>'nullable|numeric',
            'lab_technicians'=>'nullable|numeric',
            'nurse_midwife'=>'nullable|numeric',
            'him_officers'=>'nullable|numeric',
            'community_health_officer'=>'nullable|numeric',
            'community_extension_workers'=>'nullable|numeric',
            'jun_community_extension_worker'=>'nullable|numeric',
            'dental_technicians'=>'nullable|numeric',
            'env_health_officers'=>'nullable|numeric',
            'beds_accidents_emerg'=>'nullable|numeric',
            'beds_adminission'=>'nullable|numeric',
            'beds_icu'=>'nullable|numeric',
            'onsite_laboratory'=>'nullable',
            'onsite_imaging'=>'nullable',
            'onsite_pharmarcy'=>'nullable',
            'mortuary_services'=>'nullable',
        ]);
    
        
        $start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date)));

        $hosp = new hs_hospital;
        $hosp->fill($request->all());
        $hosp->unique_id = $hosp->generateUniqueID($request->lga_id,'1',$request->facility_level_id,$request->ownership_id);
        $hosp->start_date = $start_date;
        $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
        $hosp->save();
    
        session()->flash("alert-success", "Hospital/Clinic Saved Successfully!");
        return redirect()->back();
    }
    
    
    public function show($id)
    {
        // $hosp =Signature::findorfail($id);
        // // dd($hosp);
        // return view('hospitals.show', compact("hosp"));   
    }
    
    
    public function edit($id)
    {
        // $hosp =Signature::findorfail($id);
        // return view('hospitals.edit', compact("hosp"));   
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
        
        // $sign = new Signature;
        // $hosp = new Hospital;
        
        // $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        
        // $medical = $sign->arrayValuesTostring($request->medicals);
        // $surgical = $sign->arrayValuesTostring($request->surgicals);
        // $obsgyna = $sign->arrayValuesTostring($request->obs);
        // $pediat = $sign->arrayValuesTostring($request->Pediatrics);
        // $dental = $sign->arrayValuesTostring($request->dentals);
        // $opdays = $sign->arrayValuesTostring($request->operational_days);
        // $specificlincal = $sign->arrayValuesTostring($request->clinical);
        
        
        // $sign=Signature::findOrFail($id);        
        // $sign->cac_reg= $request->cac_reg;
        // $sign->comm_date=$regdate;
        // $sign->reg_fac_name= strtoupper($request->reg_fac_name);
        // $sign->alt_facility_name = strtoupper($request->alt_facility_name);
        // $sign->state = $request->state;
        // $sign->lga = $request->lga;
        // $sign->ward = $request->ward;
        // $sign->house_no = $request->house_no;
        // $sign->street_name = $request->street_name;
        // $sign->longitude = $request->longitude;
        // $sign->latitude = $request->latitude;
        // $sign->postal_address = $request->postal_address;
        // $sign->phone_number = $request->phone_number;
        // $sign->email_address = $request->email_address;
        // $sign->website = $request->website;
        // $sign->operational_days = $opdays;
        // $sign->hr_operation = $request->hr_operation;
        // $sign->operational_hours = $request->operational_hours;
        // $sign->save();
        
        // $hosp=Hospital::findOrFail($id);
        // $hosp->hs_level = $request->hs_level;
        // $hosp->hs_level_option = $request->hs_level_option;
        // $hosp->hs_sp_option = $request->hs_sp_option;
        // $hosp->hs_ownership = $request->hs_ownership;
        // $hosp->hs_ownership_type = $request->hs_ownership_type;
        // $hosp->hs_ownership_details = $request->hs_ownership_details;
        // $hosp->hs_op_status = $request->hs_op_status;
        // $hosp->hs_reg_status = $request->hs_reg_status;
        // $hosp->hs_lic_status = $request->hs_lic_status;
        // $hosp->hs_service_type_outpatient = $request->opd;
        // $hosp->hs_service_type_inpatient = $request->ipd;
        // $hosp->hs_outpatient_medical = $medical;
        // $hosp->hs_outpatient_surgery = $surgical;
        // $hosp->hs_outpatient_obstetrics = $obsgyna;
        // $hosp->hs_outpatient_pediatrics = $pediat;
        // $hosp->hs_outpatient_dental = $dental;
        // $hosp->hs_inpatient_acc_and_emg= $request->hs_inpatient_acc_and_emg;
        // $hosp->hs_inpatient_acc_and_emg_num= $request->hs_inpatient_acc_and_emg_num;
        // $hosp->hs_inpatient_adm_fac= $request->hs_inpatient_adm_fac;
        // $hosp->hs_inpatient_adm_fac_num = $request->hs_inpatient_adm_fac_num;
        // $hosp->hs_inpatient_int_care_service = $request->hs_inpatient_int_care_service;
        // $hosp->hs_inpatient_int_care_service_num = $request->hs_inpatient_int_care_service_num;
        // $hosp->hs_specific_clinical_services = $specificlincal;
        // $hosp->hs_no_doctors = $request->hs_no_doctors;
        // $hosp->hs_no_single_qualified_nurses = $request->hs_no_single_qualified_nurses;
        // $hosp->hs_no_single_qualified_midwives = $request->hs_no_single_qualified_midwives;
        // $hosp->hs_nurses_midwives = $request->hs_nurses_midwives;
        // $hosp->hs_no_pharm = $request->hs_no_pharm;
        // $hosp->hs_no_lab_sc = $request->hs_no_lab_sc;
        // $hosp->hs_no_dentist = $request->hs_no_dentist;
        // $hosp->hs_no_comm_health_officer = $request->hs_no_comm_health_officer;
        // $hosp->hs_no_comm_health_ext_officer = $request->hs_no_comm_health_ext_officer;
        // $hosp->hs_no_jun_comm_health_ext_off= $request->hs_no_jun_comm_health_ext_off;
        // $hosp->hs_onsite_pharm= $request->hs_onsite_pharm;
        // $hosp->hs_onsite_lab= $request->hs_onsite_lab;
        // $hosp->hs_onsite_radio= $request->hs_onsite_radio;
        // $hosp->hs_mort_service= $request->hs_mort_service;
        // $hosp->hs_dhis_ident= $request->hs_dhis_ident;
        // $hosp->hs_datim_ident= $request->hs_datim_ident;
        // $hosp->hs_lmis_ident= $request->hs_lmis_ident;
        // $hosp->hs_hris_ident= $request->hs_hris_ident;
        // $hosp->hs_ennrims_ident= $request->hs_ennrims_ident;
        // $hosp->hs_no_env_health_officer= $request->hs_no_env_health_officer;
        // $hosp->hs_no_lab_tech = $request->hs_no_lab_tech;
        // $hosp->hs_no_health_rec= $request->hs_no_health_rec;
        // $hosp->hs_no_pharm_tech= $request->hs_no_pharm_tech;
        // $hosp->hs_no_dental_tech= $request->hs_no_dental_tech;
        // $hosp->statecode = $request->state;
        // $hosp->save();
        
        session()->flash("alert-success", "Record Updated Successfully!");
        return redirect()->back();
    }
    
  
    public function destroy($id)
    {
        //
    }

  
}
