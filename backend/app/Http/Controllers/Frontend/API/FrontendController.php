<?php

namespace App\Http\Controllers\Frontend\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Website\API\Origin;
use App\Website\API\Process;
use App\Website\API\ProcessItem;
use App\Website\API\Slider;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function slider(): JsonResponse
    {
        $sliders = Slider::all();
        return response()->json([
            'success' => true,
            'data' => $sliders
        ], 200);
    }

    public function processItem(): JsonResponse
    {
        $processItems = ProcessItem::all();
        return response()->json([
            'success' => true,
            'data' => $processItems
        ], 200);
    }


    public function origin(): JsonResponse
    {
        $origin = Origin::where('id', 1)->first();
        return response()->json([
            'success' => true,
            'data' => $origin
        ], 200);
    }


    public function process(): JsonResponse
    {
        $process = Process::where('id', 1)->first();
        return response()->json([
            'success' => true,
            'data' => $process
        ], 200);
    }


    public function facilityType(): JsonResponse
    {
        $results = DB::table('lst_facility_types')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function facilityLevel(): JsonResponse
    {
        $results = DB::table('lst_level_of_care')
            ->select('id', 'name')
            ->get();
        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function states(): JsonResponse
    {
        $results =  DB::table('ou_states')
            ->select('id', 'name')
            ->orderByRaw('name ASC')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function getLgaListByStateId(Request $request): JsonResponse
    {
        // \Log::info($request);
        $results = DB::table('ou_lgas')
            ->select('name', 'id')
            ->where('state_id', $request->state_id)
            ->orderByRaw('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function getWardListByLGA(Request $request): JsonResponse
    {
        // \Log::info($request);
        $results = DB::table('ou_wards')
            ->select('name', 'id')
            ->where('lga_id', $request->lga_id)
            ->orderByRaw('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }


    public function getOwnership(Request $request): JsonResponse
    {
        $results = DB::table('lst_ownerships')
            ->select('id', 'name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function getOwnershipType(Request $request): JsonResponse
    {
        $results =  DB::table('lst_ownership_types')
            ->select('id', 'type')
            ->where('ownership_id', $request->ownership_id)
            ->orderByRaw('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }


    public function getOperationalStatus(Request $request): JsonResponse
    {
        $results =  DB::table('lst_oparational_status')
            ->select('id', 'status')
            ->where('category', '1')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function getRegistrationStatus(Request $request): JsonResponse
    {
        $results =  DB::table('lst_registration_status')
            ->select('id', 'status')
            ->where('category', '1')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function getLicenseStatus(Request $request): JsonResponse
    {
        $results = DB::table('lst_license_status')
            ->select('id', 'status')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function getServiceCategory(Request $request): JsonResponse
    {
        $results = DB::table('lst_hosp_service_category')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }

    public function getServicesByCategory(Request $request): JsonResponse
    {
        $results =  DB::table('lst_hosp_services')
            ->select('id', 'name')
            ->where('service_category_id', $request->service_category_id)
            ->orderByRaw('id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $results
        ], 200);
    }


    public function searchHospitals(Request $request)
    {

        // Extracting request parameters
        $ward_id = $request->ward_id == 0 ? '' : $request->ward_id;
        $facility_level_id = $request->facility_level_id == 0 ? '' : $request->facility_level_id;
        $ownership_id = $request->ownership_id == 0 ? '' : $request->ownership_id;
        $operational_status_id = $request->operational_status_id == 0 ? '' : $request->operational_status_id;
        $registration_status_id = $request->registration_status_id == 0 ? '' : $request->registration_status_id;
        $license_status_id = $request->license_status_id == 0 ? '' : $request->license_status_id;

        // Handling geo_codes conditions (compatible with PHP 7)
        if ($request->geo_codes == 0) {
            $cond = "<>";
            $value = 'XXX';
        } elseif ($request->geo_codes == 1) {
            $cond = "<>";
            $value = '';
        } elseif ($request->geo_codes == 2) {
            $cond = "=";
            $value = '';
        } else {
            $cond = "<>";
            $value = '';
        }

        // Handling service type conditions
        $outpatient = $request->service_type == 1 ? 'Yes' : '';
        $inpatient = $request->service_type == 2 ? 'Yes' : '';

        // Handling hospital services filtering
        if (!empty($request->services)) {
            $hospitalIds = DB::table('hs_hospital_services')
                ->whereIn('service_id', $request->services)
                ->distinct()
                ->pluck('hospital_id')
                ->toArray();
        } else {
            $hospitalIds = DB::table('hs_hospitals_history')->pluck('id')->toArray();
        }

        $data['facilities'] = DB::table('hs_hospitals_history')
            ->leftJoin('ou_states', 'hs_hospitals_history.state_id', '=', 'ou_states.id')
            ->leftJoin('ou_lgas', 'hs_hospitals_history.lga_id', '=', 'ou_lgas.id')
            ->leftJoin('ou_wards', 'hs_hospitals_history.ward_id', '=', 'ou_wards.id')
            ->leftJoin('lst_level_of_care', 'hs_hospitals_history.facility_level_id', '=', 'lst_level_of_care.id')
            ->leftJoin('lst_ownerships', 'hs_hospitals_history.ownership_id', '=', 'lst_ownerships.id')
            ->leftJoin('lst_oparational_status', 'hs_hospitals_history.operational_status_id', '=', 'lst_oparational_status.id')
            ->leftJoin('lst_registration_status', 'hs_hospitals_history.registration_status_id', '=', 'lst_registration_status.id')
            ->leftJoin('lst_license_status', 'hs_hospitals_history.license_status_id', '=', 'lst_license_status.id')
            ->select(
                'hs_hospitals_history.*',
                'ou_states.name as state_name',
                'ou_lgas.name as lga_name',
                'ou_wards.name as ward_name',
                'lst_level_of_care.name as facility_level_name',
                'lst_ownerships.name as ownership_name',
                'lst_oparational_status.status as operational_status_name',
                'lst_registration_status.status as registration_status_name',
                'lst_license_status.status as license_status_name'
            )
            ->where('hs_hospitals_history.state_id', 'like', '%' . $request->state_id . '%')
            ->where('hs_hospitals_history.lga_id', 'like', '%' . $request->lga_id . '%')
            ->where(DB::raw("IFNULL(hs_hospitals_history.ward_id, '')"), 'like', '%' . $ward_id . '%')
            ->where('hs_hospitals_history.facility_level_id', 'like', '%' . $facility_level_id . '%')
            ->where('hs_hospitals_history.ownership_id', 'like', '%' . $ownership_id . '%')
            ->where('hs_hospitals_history.operational_status_id', 'like', '%' . $operational_status_id . '%')
            ->where('hs_hospitals_history.registration_status_id', 'like', '%' . $registration_status_id . '%')
            ->where('hs_hospitals_history.license_status_id', 'like', '%' . $license_status_id . '%')
            ->where(DB::raw("IFNULL(hs_hospitals_history.outpatient, '')"), 'like', '%' . $outpatient . '%')
            ->where(DB::raw("IFNULL(hs_hospitals_history.inpatient, '')"), 'like', '%' . $inpatient . '%')
            ->where('hs_hospitals_history.facility_name', 'like', '%' . $request->facility_name . '%')
            ->where(DB::raw("IFNULL(hs_hospitals_history.latitude, '')"), $cond, $value)
            ->whereIn('hs_hospitals_history.id', $hospitalIds)

            ->orderBy('hs_hospitals_history.state_id')
            ->orderBy('hs_hospitals_history.lga_id')
            ->orderBy('hs_hospitals_history.ward_id')
            ->orderBy('hs_hospitals_history.facility_name')

            // ->orderBy('hs_hospitals_history.state_id', 'desc')
            // ->orderBy('hs_hospitals_history.lga_id', 'desc')
            // ->orderBy('hs_hospitals_history.ward_id', 'desc')
            // ->orderBy('hs_hospitals_history.facility_name', 'desc')
            // ->paginate(10)
            ->paginate(15)
            ->appends($request->all());


        // Returning request values
        $data += [
            'state_id' => $request->state_id,
            'lga_id' => $request->lga_id,
            'ward_id' => $request->ward_id,
            'facility_name' => $request->facility_name,
            'geo_codes' => $request->geo_codes,
            'facility_level_id' => $request->facility_level_id,
            'ownership_id' => $request->ownership_id,
            'operational_status_id' => $request->operational_status_id,
            'registration_status_id' => $request->registration_status_id,
            'license_status_id' => $request->license_status_id,
            'service_type' => $request->service_type,
            'service_category_id' => $request->service_category_id,
            'searched' => 1
        ];

        // Returning JSON response
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }


    public function getFacilitesByLGA(Request $request)
    {
        $total_facilities_lga = DB::select("SELECT l.map_code LGA_UID,count(h.id) value 
                    FROM hs_hospitals h 
                    JOIN ou_lgas l ON l.id = h.lga_id 
                    JOIN ou_states s ON s.id=l.state_id
                    WHERE s.short_code ='" . $request->state_code .
            "'GROUP BY l.map_code");


        $state = DB::table('ou_states')
            ->select('name', 'id')
            ->where('short_code', $request->state_code)
            ->get();

        $state_id = $state[0]->id;

        //get by level of care
        $by_level = DB::select("SELECT facility_level as name,COUNT(id) AS y FROM hospital_details 
                WHERE state_id=" . $state_id . " GROUP BY facility_level order by facility_level");

        //by ownership
        $by_ownership =  DB::select("SELECT ownership as name,COUNT(id) AS y FROM hospital_details 
                WHERE state_id=" . $state_id . "  GROUP BY ownership order by ownership");

        //fac with Geo codes
        $geo_codes =  DB::select("SELECT lga as name, cast(SUM(case when latitude <> '' then 1 else 0 end)/count(id)*100 as unsigned) as y 
        FROM hospital_details WHERE state_id=" . $state_id . "  GROUP BY lga order by y desc");


        $result  = array();
        $result['state'] =  $state[0]->name;
        $result['facilities'] =  $total_facilities_lga;
        $result['by_ownership'] =  $by_ownership;
        $result['by_level'] =  $by_level;
        $result['geo_codes'] =  $geo_codes;


        return response()->json([
            'success' => true,
            'data' => $result
        ], 200);
    }


    public function getFacilitesGMap(Request $request)
    {
        //get lga id and name
        $lga = DB::table('ou_lgas')
            ->select('id', 'name')
            ->where('map_code', $request->lga_code)
            ->get();

        $lga_details = array();

        foreach ($lga as $l) {
            $lga_details[0] = $l->id; //lga id
            $lga_details[1] = $l->name; //lga name
        };


        $facilities = DB::select("SELECT * FROM hospital_details where latitude != '' and 
                        lga_id='" . $lga_details[0] . "'");

        $lga_name =  $lga_details[1];

        $result  = array();
        $result['lga_name'] = $lga_name;
        $result['facilities_list'] =  $facilities;

        return response()->json([
            'success' => true,
            'data' => $result
        ], 200);
    }
}
