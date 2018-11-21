<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class LabController extends Controller
{

    public function index()
    {
        $labs = DB::table('laboratory_details')
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

        return view('laboratory.index', compact("labs"));
    }
    public function public_index()
    {
        $labs =DB::table('laboratory')->get();
        return view('public.labList', compact("labs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lab.create');                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            'hs_level'=>'required',
            'hs_ownership'=>'required',
            'hs_op_status'=>'required',
            'lb_state'=>'required',
            'lb_hr'=>'numeric',
            'lb_lab_tech'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_level.required' => 'The Laboratory level field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            'lb_state.required' => 'The Instituion/Standalone field is required',            
            'lb_hr.numeric' => 'The Laboratory Scientists field must be a number',
            'lb_lab_tech.numeric' => 'The Laboratory Technicians field must be a number'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $lab = new Lab;
        
        $max = $sign::where('id','>', 1)->max('id');
        $ids = $max + 1; //auto increment id
        $num_of_fac = $sign::where('state',$request->state)
        ->where('lga',$request->lga)
        ->count();
        $num_of_fac = $num_of_fac + 1; //get serial number of the next HF in LGA
        
        $UniqueID = $sign->makeID($request->state,$request->lga,"3",$request->hs_level,$request->hs_ownership,$num_of_fac);
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        $cert_date_nat = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_cert_ng)));
        $exp_date_nat = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_exp_cert_ng)));
        $cert_date_int = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_cert_int)));
        $exp_date_int = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_exp_cert_int)));

        
        $opdays = $sign->arrayValuesTostring($request->operational_days);
        $lab_equips = $sign->arrayValuesTostring($request->lab_equip);
        
        $sign->id=$ids;
        $sign->sig_unique_id=$UniqueID;
        $sign->fac_tpye='3';
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
        
        $lab->lb_id = $ids;     
        $lab->lb_hs_unique_id = "";
        $lab->lb_sig_unique_id = $UniqueID;
        $lab->lb_state = $request->lb_state;
        $lab->lb_reg_num = $request->lb_reg_num;
        $lab->lb_level = $request->hs_level;
        $lab->lb_owner = $request->hs_ownership;
        $lab->lb_owner_type = $request->hs_ownership_type;
        $lab->lb_owner_dt = $request->hs_ownership_details;
        $lab->lb_op_status = $request->hs_op_status;
        $lab->lb_reg_status = $request->hs_reg_status;
        $lab->lb_acc_status = $request->lb_acc_status;
        $lab->lb_lic_status = $request->hs_lic_status;
        $lab->lb_cert_ng = $request->national;
        $lab->lb_cert_ng_type = $request->nat_cert;
        $lab->lb_dt_cert_ng = $cert_date_nat;
        $lab->lb_dt_exp_cert_ng = $exp_date_nat;
        $lab->lb_cert_int = $request->international;
        $lab->lb_cert_int_type = $request->int_cert;
        $lab->lb_dt_cert_int = $cert_date_int;
        $lab->lb_dt_exp_cert_int = $exp_date_int;
        $lab->lb_enrol = $request->lb_enrol;
        $lab->lb_hr = $request->lb_hr;
        //$lab->lb_dt_created = $request
        $lab->lb_flag_old = 'No';
        $lab->statecode = $request->state;
        $lab->lb_lab_tech = $request->lb_lab_tech;
        $lab->lb_flag = '0';
        $lab->lb_eq_id = $lab_equips;
        $lab->save();
        
        session()->flash("alert-success","Laboratory Information Saved Successfully!");
        return redirect()->back();
    }


    public function show($id)
    {
        $labs =Signature::findorfail($id);
        return view('lab.show', compact("labs")); 
    }

    public function edit($id)
    {
        $labs =Signature::findorfail($id);
        return view('lab.edit', compact("labs")); 
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
            'lb_state'=>'required',
            'lb_hr'=>'numeric',
            'lb_lab_tech'=>'numeric'
        ];
        $customMessages = [
            'reg_fac_name.required' => 'The Facility name field is required',
            'state.required' => 'The State field is required',
            'lga.required' => 'The LGA field is required',
            'hs_level.required' => 'The Laboratory level field is required',
            'hs_ownership.required' => 'The Ownership field is required',
            'hs_op_status.required' => 'The Operation status field is required',
            'lb_state.required' => 'The Instituion/Standalone field is required',            
            'lb_hr.numeric' => 'The Laboratory Scientists field must be a number',
            'lb_lab_tech.numeric' => 'The Laboratory Technicians field must be a number'
        ];
        
        $this->validate($request, $rules, $customMessages);
        
        $sign = new Signature;
        $lab = new Lab;
        
        
        $regdate = date('Y-m-d', strtotime(str_replace('-', '/', $request->comm_date)));
        $cert_date_nat = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_cert_ng)));
        $exp_date_nat = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_exp_cert_ng)));
        $cert_date_int = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_cert_int)));
        $exp_date_int = date('Y-m-d', strtotime(str_replace('-', '/', $request->lb_dt_exp_cert_int)));

        $opdays = $sign->arrayValuesTostring($request->operational_days);
        $lab_equips = $sign->arrayValuesTostring($request->lab_equip);
        
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
        
        $lab=Lab::findOrFail($id);   
        $lab->lb_hs_unique_id = "";
        $lab->lb_state = $request->lb_state;
        $lab->lb_reg_num = $request->lb_reg_num;
        $lab->lb_level = $request->hs_level;
        $lab->lb_owner = $request->hs_ownership;
        $lab->lb_owner_type = $request->hs_ownership_type;
        $lab->lb_owner_dt = $request->hs_ownership_details;
        $lab->lb_op_status = $request->hs_op_status;
        $lab->lb_reg_status = $request->hs_reg_status;
        $lab->lb_acc_status = $request->lb_acc_status;
        $lab->lb_lic_status = $request->hs_lic_status;
        $lab->lb_cert_ng = $request->national;
        $lab->lb_cert_ng_type = $request->nat_cert;
        $lab->lb_dt_cert_ng = $cert_date_nat;
        $lab->lb_dt_exp_cert_ng = $exp_date_nat;
        $lab->lb_cert_int = $request->international;
        $lab->lb_cert_int_type = $request->int_cert;
        $lab->lb_dt_cert_int = $cert_date_int;
        $lab->lb_dt_exp_cert_int = $exp_date_int;
        $lab->lb_enrol = $request->lb_enrol;
        $lab->lb_hr = $request->lb_hr;
        //$lab->lb_dt_created = $request
        $lab->lb_flag_old = 'No';
        $lab->statecode = $request->state;
        $lab->lb_lab_tech = $request->lb_lab_tech;
        $lab->lb_flag = '0';
        $lab->lb_eq_id = $lab_equips;
        $lab->save();
        
        session()->flash("alert-success","Record Updated Saved Successfully!");
        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }

    public function fetchEquips(Request $request)
    {
        $data = DB::table('tbl_lab_equipment')
                ->select('lab_eq_id','lab_eq_name')        
                ->get();
        
        $output = '';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->lab_eq_id.'">'.$row->lab_eq_name.'</option>';
        }
        return $output;
    }
    public function fetchCert(Request $request)
    {
        $data = DB::table('tbl_lab_certificate')
                ->select('lc_id','lc_name')
                ->where('lc_cert_type',$request->type)     
                ->get();

        $output = '<option value="">Select Certification </option>';
        foreach($data as $row)
        {
            $output .= '<option value="'.$row->lc_id.'">'.$row->lc_name.'</option>';
        }
        return $output;
    }
    
}
