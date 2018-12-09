<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\hs_hospital;
use App\hs_hospital_history;
use App\hs_hospital_service;
use Auth;

class HospitalsController extends Controller
{
    
    public function index()
    {
        $facilities = DB::table('hospital_details')
            ->Where('state_id', 'like', '%' .  Auth::user()->state_id . '%')
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
        
        return view('hospitals.create',compact('lst_level_of_care','lst_states','lst_ownerships','lst_oparational_status',
        'lst_regulatory_status','lst_license_status')); 
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'registration_no'=>'nullable|max:20',
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
            'pharmacists'=>'nullable|numeric',
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
        
        $hosp = new hs_hospital_history;
        $hosp->fill($request->all());
        $hosp->unique_id = $hosp->generateUniqueID($request->lga_id,'1',$request->facility_level_id,$request->ownership_id);
        $hosp->start_date = $start_date;
        $hosp->status_id = 1;
        $hosp->created_by = Auth::user()->id;
        $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
        $hosp->save();
    
        session()->flash("alert-success", "Request Sent Successfully!");
        return redirect()->back();
    }
    
    
    
    public function edit($id)
    {
            $hosp =hs_hospital::findorfail($id);
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
            
            return view('hospitals.edit',compact('hosp','lst_level_of_care','lst_states','lst_ownerships','lst_oparational_status',
            'lst_regulatory_status','lst_license_status')); 
    }
    
  
    public function update(Request $request, $id)
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

        $hosp = hs_hospital::findOrFail($id);
        $hosp->fill($request->all());
        $hosp->start_date = $start_date;
        $hosp->operational_days = $hosp->arrayValuesTostring($request->operational_days);
        $hosp->save();
    
        session()->flash("alert-success", "Record Updated Successfully!");
        return redirect()->back();
    }
    
  
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $facility_name = $request->facility_name;
      

         $facilities = DB::table('hospital_details')
        ->select('state','lga','ward','unique_id','facility_name','facility_level','ownership','id')
        ->where('state_id','like','%'.$state_id.'%')
        ->where('lga_id','like','%'.$lga_id.'%')
        ->Where('facility_name', 'like', '%' .  $facility_name . '%')
        ->orderByRaw('state','lga','facility_name')
        ->paginate(20);

        $facilities->appends([
            'state_id'=>$request->state_id,
            'lga_id'=>$request->lga_id,
            'facility_name'=>$request->facility_name,
        ]);

        //get state list
        $lst_states = Cache::remember('lst_states', 60, function () {
            return DB::table('ou_states')
                    ->select('id','name')
                    ->orderByRaw('name ASC')
                    ->get();
        });
      
        return view('hospitals.index',compact('facilities','lst_states','state_id','facility_name'));       
    }

    public function services($id)
    {
        $hosp = DB::table('hospital_details')
                ->select('unique_id','facility_name','id')
                ->where('id',$id)
                ->get();
        
        $categories = DB::select("select id,description category from lst_hosp_service_category");
              
        $hs_services = DB::select("SELECT id,service_category_id category_id,name service FROM lst_hosp_services");

        $data = DB::select("select service_id id from hs_hospital_services where hospital_id='".$id."'");
       
        $available_services = [];
        foreach ($data as $d) {
            $available_services[] = $d->id;
        }
      
        //dd($available_services);  
        return view('hospitals.services',compact('hosp','hs_services','categories','available_services'));   
    }

    public function StoreServices(Request $request)
    {
        $data = $request->services;
        //dd($data);

        //delete existing records
        $deleted = DB::delete("delete from hs_hospital_services where hospital_id ='".$request->hospital_id."' and id > 0");

        foreach ($data as $id) {
            $hosp_services = new hs_hospital_service;

            $hosp_services->service_id = $id;
            $hosp_services->hospital_id = $request->hospital_id; 
            $hosp_services->save();
        }
       
        session()->flash("alert-success", "Services added Successfully!");
        return redirect()->back();
    }

}
