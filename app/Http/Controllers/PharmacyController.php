<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Pharmacie;
use App\hs_hospital;


class PharmacyController extends Controller
{
    public function index()
    {
        $pharmacies = DB::table('pharmacy_details')
            ->select('state','lga','ward','unique_id','facility_name','ownership','id')
            ->orderByRaw('state','lga','facility_name')
            ->paginate(15);
        
        //get state list
        $lst_states = Cache::remember('lst_states', 60, function () {
        return DB::table('ou_states')
                ->select('id','name')
                ->orderByRaw('name ASC')
                ->get();
        });
        return view('pharmacy.index', compact('pharmacies','lst_states'));
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
                //get regulatory status
                $lst_registration_status= Cache::remember('lst_registration_status', 60, function () {
                return DB::table('lst_registration_status')
                        ->select('id','status')
                        ->get();
                });
                //get license status
                $lst_license_status= Cache::remember('lst_license_status', 60, function () {
                    return DB::table('lst_license_status')
                            ->select('id','status')
                            ->get();
                });
                 //get outlet category
                $lst_outlet_category= Cache::remember('lst_outlet_category', 60, function () {
                    return DB::table('lst_outlet_category')
                            ->select('id','name')
                            ->get();
                });
                 //get premises types
                 $lst_premises_type= Cache::remember('lst_premises_type', 60, function () {
                    return DB::table('lst_premises_type')
                            ->select('id','name')
                            ->get();
                });
                

                return view('pharmacy.create',compact('lst_states','lst_ownerships','lst_oparational_status',
                'lst_registration_status','lst_license_status','lst_premises_type','lst_outlet_category'));        
    }

 
    public function store(Request $request)
    {
        $request->validate([
            'registration_no'=>'nullable',
            'start_date'=>'nullable|date',
            'pharmacists_reg_number'=>'nullable',
            'facility_name'=>'required|max:200',
            'alt_facility_name'=>'nullable|max:200',
            'state_id'=>'required',
            'lga_id'=>'required',
            'ward_id'=>'required',
            'ownership_id'=>'required',
            'ownership_type_id'=>'required',
            'ownership_details'=>'nullable',
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
            'outlet_category_id'=>'nullable',
            'premises_type_id'=>'nullable',
            'pharmacists'=>'nullable|numeric',
            'pharmacy_technicians'=>'nullable|numeric',
        ]);
    
        
        $start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date)));

        $hosp = new hs_hospital;
        $ph = new Pharmacie;
        $ph->fill($request->all());
        $ph->unique_id = $hosp->generateUniqueID($request->lga_id,'2','0',$request->ownership_id);
        $ph->start_date = $start_date;
        $ph->operational_days = $hosp->arrayValuesTostring($request->operational_days);
        $ph->save();
    
        session()->flash("alert-success", "Information Saved Successfully!");
        return redirect()->back();
    }

    public function show($id)
    {
        
    }


    public function edit($id)
    {
      
    }

    public function update(Request $request, $id)
    {
    
     

    }

    public function destroy($id)
    {
        //
    }
}
