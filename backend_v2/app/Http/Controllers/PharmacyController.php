<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Models\Pharmacy;
use App\Models\HospitalHistory;
use Illuminate\Support\Facades\Log;

class PharmacyController extends Controller
{
    public function indexold()
    {
        $pharmacies = DB::table('pharmacy_details')
            ->orderBy('state')
            ->orderBy('lga')
            ->orderBy('facility_name')
            ->paginate(20);


        list(
            $state_id,
            $lga_id,
            $facility_name,
            $geo_codes,
            $ward_id,
            $ownership_id,
            $operational_status_id,
            $registration_status_id,
            $license_status_id
        ) = [1, 1, "", 0, 0, 0, 0, 0, 0, 0, 0];

        return view('pharmacy.index', compact(
            'pharmacies',
            'state_id',
            'lga_id',
            'facility_name',
            'geo_codes',
            'ward_id',
            'ownership_id',
            'operational_status_id',
            'registration_status_id',
            'license_status_id'
        ));
    }

    public function index()
    {
        $pharmacies = DB::table('pharmacy_details')
            ->join('ou_states', 'pharmacy_details.state_id', '=', 'ou_states.id')
            ->join('ou_lgas', 'pharmacy_details.lga_id', '=', 'ou_lgas.id')
            ->join('ou_wards', 'pharmacy_details.ward_id', '=', 'ou_wards.id')
            ->join('lst_ownerships', 'pharmacy_details.ownership_id', '=', 'lst_ownerships.id')
            ->select(
                'pharmacy_details.*',
                'ou_states.name as state',
                'ou_lgas.name as lga',
                'ou_wards.name as ward',
                'lst_ownerships.name as ownership',
            )
            ->orderBy('ou_states.name')
            ->orderBy('ou_lgas.name')
            ->orderBy('pharmacy_details.facility_name')
            ->paginate(20);

        list(
            $state_id,
            $lga_id,
            $facility_name,
            $geo_codes,
            $ward_id,
            $ownership_id,
            $operational_status_id,
            $registration_status_id,
            $license_status_id
        ) =
            [1, 1, "", 0, 0, 0, 0, 0, 0];

        return view('pharmacy.index', compact(
            'pharmacies',
            'state_id',
            'lga_id',
            'facility_name',
            'geo_codes',
            'ward_id',
            'ownership_id',
            'operational_status_id',
            'registration_status_id',
            'license_status_id'
        ));
    }


    public function create()
    {
        return view('pharmacy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'registration_no' => 'nullable',
            'start_date' => 'nullable|date',
            'pharmacists_reg_number' => 'nullable',
            'facility_name' => 'required|max:200',
            'alt_facility_name' => 'nullable|max:200',
            'state_id' => 'required',
            'lga_id' => 'required',
            'ward_id' => 'required',
            'ownership_id' => 'required',
            'ownership_type_id' => 'required',
            'ownership_details' => 'nullable',
            'house_no' => 'nullable',
            'street_name' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'postal_address' => 'nullable',
            'phone_number' => 'nullable',
            'email_address' => 'nullable|email',
            'website' => 'nullable',
            'operational_days' => 'nullable',
            'operational_hours' => 'nullable',
            'operational_status_id' => 'required',
            'regulatory_status_id' => 'nullable',
            'license_status_id' => 'nullable',
            'outlet_category_id' => 'nullable',
            'premises_type_id' => 'nullable',
            'pharmacists' => 'nullable|numeric',
            'pharmacy_technicians' => 'nullable|numeric',
        ]);

        $start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date)));

        $hosp = new HospitalHistory;
        $ph = new Pharmacy;
        $ph->fill($request->all());
        $ph->unique_id = $hosp->generateFacilityCode($request->lga_id, '2', '0', $request->ownership_id);
        $ph->start_date = $start_date;
        $ph->operational_days = $hosp->arrayValuesTostring($request->operational_days);

        DB::beginTransaction();
        try {
            $ph->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        session()->flash("alert-success", "Pharmacy Information Saved Successfully!");
        return redirect()->back();
    }

    public function show($id)
    {
        $pharmacy = DB::table('pharmacy_details')
            ->join('ou_states', 'pharmacy_details.state_id', '=', 'ou_states.id')
            ->join('ou_lgas', 'pharmacy_details.lga_id', '=', 'ou_lgas.id')
            ->join('ou_wards', 'pharmacy_details.ward_id', '=', 'ou_wards.id')
            ->join('lst_ownerships', 'pharmacy_details.ownership_id', '=', 'lst_ownerships.id')
            ->join('lst_ownership_types', 'pharmacy_details.ownership_type_id', '=', 'lst_ownership_types.id')
            // ->join('lst_level_of_care', 'laboratory_details.facility_level_id', '=', 'lst_level_of_care.id')
            ->select(
                'pharmacy_details.*',
                'ou_states.name as state',
                'ou_lgas.name as lga',
                'ou_wards.name as ward',
                'lst_ownerships.name as ownership',
                // 'lst_level_of_care.name as facility_level',
                'lst_ownership_types.type as ownership_type'
            )
            ->where('pharmacy_details.id', $id)
            ->first();

        if (!$pharmacy) {
            return response()->json(['error' => 'Pharmacy not found'], 404);
        }

        // Log::info(json_encode($pharmacy));

        $html = view('pharmacy.partials.details', compact('pharmacy'));
        return $html;
    }


    public function edit($id)
    {
        $pharmacy = Pharmacy::findorfail($id);
        return view('pharmacy.edit', compact("pharmacy"));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'registration_no' => 'nullable',
            'start_date' => 'nullable|date',
            'pharmacists_reg_number' => 'nullable',
            'facility_name' => 'required|max:200',
            'alt_facility_name' => 'nullable|max:200',
            'state_id' => 'required',
            'lga_id' => 'required',
            'ward_id' => 'required',
            'ownership_id' => 'required',
            'ownership_type_id' => 'required',
            'ownership_details' => 'nullable',
            'house_no' => 'nullable',
            'street_name' => 'nullable',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
            'postal_address' => 'nullable',
            'phone_number' => 'nullable',
            'email_address' => 'nullable|email',
            'website' => 'nullable',
            'operational_days' => 'nullable',
            'operational_hours' => 'nullable',
            'operational_status_id' => 'required',
            'regulatory_status_id' => 'nullable',
            'license_status_id' => 'nullable',
            'outlet_category_id' => 'nullable',
            'premises_type_id' => 'nullable',
            'pharmacists' => 'nullable|numeric',
            'pharmacy_technicians' => 'nullable|numeric',
        ]);

        $hosp = new HospitalHistory;
        $ph = Pharmacy::findorfail($id);
        $ph->fill($request->all());
        $ph->start_date = date('Y-m-d', strtotime(str_replace('-', '/', $request->start_date)));
        $ph->operational_days = $hosp->arrayValuesTostring($request->operational_days);

        DB::beginTransaction();
        try {
            $ph->save();

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json(['error' => $ex->getMessage()], 500);
        }

        session()->flash("alert-success", "Pharmacy Information Updated Successfully!");
        return redirect()->back();
    }

    public function destroy(Request $request)
    {
        Pharmacy::destroy($request->fac_id);
        session()->flash("alert-success", "Pharmacy deleted successfully!");
        return back();
    }

    public function search(Request $request)
    {
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $ward_id = $request->ward_id;
        $facility_name = $request->facility_name;
        $geo_codes = $request->geo_codes;
        $ownership_id = $request->ownership_id;
        $operational_status_id = $request->operational_status_id;
        $registration_status_id = $request->registration_status_id;
        $license_status_id = $request->license_status_id;

        if ($geo_codes == 0) {
            $cond = "<>";
            $value = 'XXX';
        }
        if ($geo_codes == 1) {
            $cond = "<>";
            $value = '';
        }
        if ($geo_codes == 2) {
            $cond = "=";
            $value = '';
        }


        if ($ward_id == 0) {
            $ward_id = '';
        }

        if ($ownership_id == 0) {
            $ownership_id = '';
        }
        if ($operational_status_id == 0) {
            $operational_status_id = '';
        }
        if ($registration_status_id == 0) {
            $registration_status_id = '';
        }
        if ($license_status_id == 0) {
            $license_status_id = '';
        }


        $pharmacies = DB::table('pharmacy_details')
            ->join('ou_states', 'pharmacy_details.state_id', '=', 'ou_states.id')
            ->join('ou_lgas', 'pharmacy_details.lga_id', '=', 'ou_lgas.id')
            ->join('ou_wards', 'pharmacy_details.ward_id', '=', 'ou_wards.id')
            ->join('lst_ownerships', 'pharmacy_details.ownership_id', '=', 'lst_ownerships.id')
            ->select(
                'pharmacy_details.*',
                'ou_states.name as state',
                'ou_lgas.name as lga',
                'ou_wards.name as ward',
                'lst_ownerships.name as ownership',
            )
            ->where('pharmacy_details.state_id', 'like', '%' . $state_id . '%')
            ->where('pharmacy_details.lga_id', 'like', '%' . $lga_id . '%')
            ->where(DB::Raw("IFNULL(pharmacy_details.ward_id, '')"), 'like', '%' . $ward_id . '%')
            ->where('pharmacy_details.ownership_id', 'like', '%' . $ownership_id . '%')
            ->where(DB::Raw("IFNULL(pharmacy_details.operational_status_id, '')"), 'like', '%' . $operational_status_id . '%')
            ->where(DB::Raw("IFNULL(pharmacy_details.registration_status_id, '')"), 'like', '%' . $registration_status_id . '%')
            ->where(DB::Raw("IFNULL(pharmacy_details.license_status_id, '')"), 'like', '%' . $license_status_id . '%')
            ->Where('pharmacy_details.facility_name', 'like', '%' .  $facility_name . '%')
            ->where(DB::Raw("IFNULL(pharmacy_details.latitude, '')"), $cond, $value)
            ->orderBy('pharmacy_details.state_id')
            ->orderBy('pharmacy_details.lga_id')
            ->orderBy('pharmacy_details.facility_name')
            ->paginate(20)
            ->appends($request->all());


        //return original values from request
        $state_id = $request->state_id;
        $lga_id = $request->lga_id;
        $ward_id = $request->ward_id;
        $facility_name = $request->facility_name;
        $geo_codes = $request->geo_codes;
        $facility_level_id = $request->facility_level_id;
        $ownership_id = $request->ownership_id;
        $operational_status_id = $request->operational_status_id;
        $registration_status_id = $request->registration_status_id;
        $license_status_id = $request->license_status_id;


        return view('pharmacy.index', compact(
            'pharmacies',
            'state_id',
            'lga_id',
            'facility_name',
            'geo_codes',
            'ward_id',
            'ownership_id',
            'operational_status_id',
            'registration_status_id',
            'license_status_id'
        ));
    }
}
