<?php

namespace App\Http\Controllers\Approval;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function tracking(Request $request)
    {
        $pending = DB::table('hospital_details_history')
            ->join('ou_states', 'hospital_details_history.state_id', '=', 'ou_states.id')
            ->join('ou_lgas', 'hospital_details_history.lga_id', '=', 'ou_lgas.id')
            ->join('ou_wards', 'hospital_details_history.ward_id', '=', 'ou_wards.id')
            ->join('lst_facility_types', 'hospital_details_history.facility_type_id', '=', 'lst_facility_types.id')
            ->join('lst_level_of_care', 'hospital_details_history.facility_level_id', '=', 'lst_level_of_care.id')
            ->join('lst_ownerships', 'hospital_details_history.ownership_id', '=', 'lst_ownerships.id')
            ->join('lst_ownership_types', 'hospital_details_history.ownership_type_id', '=', 'lst_ownership_types.id')
            ->join('lst_level_of_care_options', 'hospital_details_history.facility_level_option_id', '=', 'lst_level_of_care_options.id')
            ->join('lst_oparational_status', 'hospital_details_history.operational_status_id', '=', 'lst_oparational_status.id')
            ->join('lst_registration_status', 'hospital_details_history.registration_status_id', '=', 'lst_registration_status.id')
            ->join('lst_license_status', 'hospital_details_history.license_status_id', '=', 'lst_license_status.id')
            ->join('users', 'hospital_details_history.requested_by', '=', 'users.id')
            ->select(
                'hospital_details_history.*',
                'ou_states.name as state',
                'ou_lgas.name as lga',
                'ou_wards.name as ward',
                'lst_ownerships.name as ownership',
                'lst_ownership_types.type as ownership_type',
                'lst_level_of_care.name as facility_level',
                'lst_level_of_care_options.description as facility_level_option',
                'lst_oparational_status.status as operation_status',
                'lst_registration_status.status as registration_status',
                'lst_license_status.status as license_status',
                'users.lastname as requested_by_lastname',
                'users.firstname as requested_by_firstname',
                'users.email as requested_email',
                'users.mobile as requested_mobile'
            )
            ->whereIn('hospital_details_history.status_id', [1, 8, 15, 5, 12, 19])
            ->orderby('hospital_details_history.updated_at', 'desc')
            ->get();

        $message = $pending->count() . " pending verifications";

        return view('approvals.approval_tracking', compact('pending', 'message'));
    }

    public function tracking_search(Request $request)
    {
        if ($request->approval == 1) {
            $pending = DB::table('hospital_details_history')
                ->join('ou_states', 'hospital_details_history.state_id', '=', 'ou_states.id')
                ->join('ou_lgas', 'hospital_details_history.lga_id', '=', 'ou_lgas.id')
                ->join('ou_wards', 'hospital_details_history.ward_id', '=', 'ou_wards.id')
                ->join('lst_facility_types', 'hospital_details_history.facility_type_id', '=', 'lst_facility_types.id')
                ->join('lst_level_of_care', 'hospital_details_history.facility_level_id', '=', 'lst_level_of_care.id')
                ->join('lst_ownerships', 'hospital_details_history.ownership_id', '=', 'lst_ownerships.id')
                ->join('lst_ownership_types', 'hospital_details_history.ownership_type_id', '=', 'lst_ownership_types.id')
                ->join('lst_level_of_care_options', 'hospital_details_history.facility_level_option_id', '=', 'lst_level_of_care_options.id')
                ->join('lst_oparational_status', 'hospital_details_history.operational_status_id', '=', 'lst_oparational_status.id')
                ->join('lst_registration_status', 'hospital_details_history.registration_status_id', '=', 'lst_registration_status.id')
                ->join('lst_license_status', 'hospital_details_history.license_status_id', '=', 'lst_license_status.id')
                ->join('users', 'hospital_details_history.requested_by', '=', 'users.id')
                ->select(
                    'hospital_details_history.*',
                    'ou_states.name as state',
                    'ou_lgas.name as lga',
                    'ou_wards.name as ward',
                    'lst_ownerships.name as ownership',
                    'lst_ownership_types.type as ownership_type',
                    'lst_level_of_care.name as facility_level',
                    'lst_level_of_care_options.description as facility_level_option',
                    'lst_oparational_status.status as operation_status',
                    'lst_registration_status.status as registration_status',
                    'lst_license_status.status as license_status',
                    'users.lastname as requested_by_lastname',
                    'users.firstname as requested_by_firstname',
                    'users.email as requested_email',
                    'users.mobile as requested_mobile'
                )
                ->where('hospital_details_history.state_id', 'like', '%' .  $request->state_id . '%')
                ->where('hospital_details_history.action', 'like', '%' .  $request->action . '%')
                ->whereIn('hospital_details_history.status_id', [1, 8, 15, 5, 12, 19])
                ->orderby('hospital_details_history.updated_at', 'desc')
                ->get();

            $message = $pending->count() . " pending verifications";
        } elseif ($request->approval == 2) {
            $pending  = DB::table('hospital_details_history')
                ->join('ou_states', 'hospital_details_history.state_id', '=', 'ou_states.id')
                ->join('ou_lgas', 'hospital_details_history.lga_id', '=', 'ou_lgas.id')
                ->join('ou_wards', 'hospital_details_history.ward_id', '=', 'ou_wards.id')
                ->join('lst_facility_types', 'hospital_details_history.facility_type_id', '=', 'lst_facility_types.id')
                ->join('lst_level_of_care', 'hospital_details_history.facility_level_id', '=', 'lst_level_of_care.id')
                ->join('lst_ownerships', 'hospital_details_history.ownership_id', '=', 'lst_ownerships.id')
                ->join('lst_ownership_types', 'hospital_details_history.ownership_type_id', '=', 'lst_ownership_types.id')
                ->join('lst_level_of_care_options', 'hospital_details_history.facility_level_option_id', '=', 'lst_level_of_care_options.id')
                ->join('lst_oparational_status', 'hospital_details_history.operational_status_id', '=', 'lst_oparational_status.id')
                ->join('lst_registration_status', 'hospital_details_history.registration_status_id', '=', 'lst_registration_status.id')
                ->join('lst_license_status', 'hospital_details_history.license_status_id', '=', 'lst_license_status.id')
                ->join('users', 'hospital_details_history.requested_by', '=', 'users.id')
                ->select(
                    'hospital_details_history.*',
                    'ou_states.name as state',
                    'ou_lgas.name as lga',
                    'ou_wards.name as ward',
                    'lst_ownerships.name as ownership',
                    'lst_ownership_types.type as ownership_type',
                    'lst_level_of_care.name as facility_level',
                    'lst_level_of_care_options.description as facility_level_option',
                    'lst_oparational_status.status as operation_status',
                    'lst_registration_status.status as registration_status',
                    'lst_license_status.status as license_status',
                    'users.lastname as requested_by_lastname',
                    'users.firstname as requested_by_firstname',
                    'users.email as requested_email',
                    'users.mobile as requested_mobile'
                )
                ->where('hospital_details_history.state_id', 'like', '%' .  $request->state_id . '%')
                ->where('hospital_details_history.action', 'like', '%' .  $request->action . '%')
                ->whereIn('hospital_details_history.status_id', [2, 7, 9, 14, 16, 21])
                ->get();

            $message = $pending->count() . " pending validations";
        } else {
            $pending = DB::table('hospital_details_history')
                ->join('ou_states', 'hospital_details_history.state_id', '=', 'ou_states.id')
                ->join('ou_lgas', 'hospital_details_history.lga_id', '=', 'ou_lgas.id')
                ->join('ou_wards', 'hospital_details_history.ward_id', '=', 'ou_wards.id')
                ->join('lst_facility_types', 'hospital_details_history.facility_type_id', '=', 'lst_facility_types.id')
                ->join('lst_level_of_care', 'hospital_details_history.facility_level_id', '=', 'lst_level_of_care.id')
                ->join('lst_ownerships', 'hospital_details_history.ownership_id', '=', 'lst_ownerships.id')
                ->join('lst_ownership_types', 'hospital_details_history.ownership_type_id', '=', 'lst_ownership_types.id')
                ->join('lst_level_of_care_options', 'hospital_details_history.facility_level_option_id', '=', 'lst_level_of_care_options.id')
                ->join('lst_oparational_status', 'hospital_details_history.operational_status_id', '=', 'lst_oparational_status.id')
                ->join('lst_registration_status', 'hospital_details_history.registration_status_id', '=', 'lst_registration_status.id')
                ->join('lst_license_status', 'hospital_details_history.license_status_id', '=', 'lst_license_status.id')
                ->join('users', 'hospital_details_history.requested_by', '=', 'users.id')
                ->select(
                    'hospital_details_history.*',
                    'ou_states.name as state',
                    'ou_lgas.name as lga',
                    'ou_wards.name as ward',
                    'lst_ownerships.name as ownership',
                    'lst_ownership_types.type as ownership_type',
                    'lst_level_of_care.name as facility_level',
                    'lst_level_of_care_options.description as facility_level_option',
                    'lst_oparational_status.status as operation_status',
                    'lst_registration_status.status as registration_status',
                    'lst_license_status.status as license_status',
                    'users.lastname as requested_by_lastname',
                    'users.firstname as requested_by_firstname',
                    'users.email as requested_email',
                    'users.mobile as requested_mobile'
                )
                ->where('hospital_details_history.state_id', 'like', '%' .  $request->state_id . '%')
                ->where('hospital_details_history.action', 'like', '%' .  $request->action . '%')
                ->whereIn('hospital_details_history.status_id', [4, 11, 18])
                ->get();

            $message = $pending->count() . " pending publications";
        }

        $request->flash('request', $request);
        return view('approvals.approval_tracking', compact('pending', 'message'));
    }
}
