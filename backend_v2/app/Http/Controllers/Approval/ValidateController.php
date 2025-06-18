<?php

namespace App\Http\Controllers\Approval;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\StatusTracking;
use Auth;
use Carbon\Carbon;
use App\Models\HospitalHistory;
use App\Models\HospitalServiceHistory;
use App\Models\audit;
use App\Models\ApprovalNotifications;
use Illuminate\Support\Facades\Log;

class ValidateController extends Controller
{
    public function index()
    {

        if (auth()->user()->hasAnyPermission(['lga_1000'])) {
            Log::info('User has permission to view all pending validations.');
            Log::info('State ID: ' . Auth::user()->state_id);
            Log::info('User Permissions: ' . json_encode(auth()->user()->getDirectPermissions()->pluck('id')->toArray()));

            $pending  = DB::table('hospital_details_history')
                ->join('ou_states', 'hospital_details_history.state_id', '=', 'ou_states.id')
                ->join('ou_lgas', 'hospital_details_history.lga_id', '=', 'ou_lgas.id')
                ->join('users', 'hospital_details_history.requested_by', '=', 'users.id')
                ->join('ou_wards', 'hospital_details_history.ward_id', '=', 'ou_wards.id')
                ->join('lst_facility_types', 'hospital_details_history.facility_type_id', '=', 'lst_facility_types.id')
                ->join('lst_ownerships', 'hospital_details_history.ownership_id', '=', 'lst_ownerships.id')
                ->join('lst_ownership_types', 'hospital_details_history.ownership_type_id', '=', 'lst_ownership_types.id')
                ->join('lst_level_of_care', 'hospital_details_history.facility_level_id', '=', 'lst_level_of_care.id')
                ->join('lst_level_of_care_options', 'hospital_details_history.facility_level_option_id', '=', 'lst_level_of_care_options.id')
                ->join('lst_oparational_status', 'hospital_details_history.operational_status_id', '=', 'lst_oparational_status.id')
                ->join('lst_registration_status', 'hospital_details_history.registration_status_id', '=', 'lst_registration_status.id')
                ->join('lst_license_status', 'hospital_details_history.license_status_id', '=', 'lst_license_status.id')

                ->select(
                    'hospital_details_history.*',
                    'ou_states.name as state',
                    'ou_lgas.name as lga',
                    'ou_wards.name as ward',

                    'lst_facility_types.name as facility_type_name',
                    'lst_level_of_care.name as facility_level_name',
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
                ->where('hospital_details_history.state_id', '=', Auth::user()->state_id)
                ->whereIn('hospital_details_history.status_id', [2, 7, 9, 14, 16, 21])
                ->get();
        } else {

            Log::info('User has limited permissions to view pending validations.');
            Log::info('State ID: ' . Auth::user()->state_id);
            Log::info('User Permissions: ' . json_encode(auth()->user()->getDirectPermissions()->pluck('id')->toArray()));
            $pending  = DB::table('hospital_details_history')
                ->join('ou_states', 'hospital_details_history.state_id', '=', 'ou_states.id')
                ->join('ou_lgas', 'hospital_details_history.lga_id', '=', 'ou_lgas.id')
                ->join('users', 'hospital_details_history.requested_by', '=', 'users.id')
                ->join('ou_wards', 'hospital_details_history.ward_id', '=', 'ou_wards.id')
                ->join('lst_facility_types', 'hospital_details_history.facility_type_id', '=', 'lst_facility_types.id')
                ->join('lst_ownerships', 'hospital_details_history.ownership_id', '=', 'lst_ownerships.id')
                ->join('lst_ownership_types', 'hospital_details_history.ownership_type_id', '=', 'lst_ownership_types.id')
                ->join('lst_level_of_care', 'hospital_details_history.facility_level_id', '=', 'lst_level_of_care.id')
                ->join('lst_level_of_care_options', 'hospital_details_history.facility_level_option_id', '=', 'lst_level_of_care_options.id')
                ->join('lst_oparational_status', 'hospital_details_history.operational_status_id', '=', 'lst_oparational_status.id')
                ->join('lst_registration_status', 'hospital_details_history.registration_status_id', '=', 'lst_registration_status.id')
                ->join('lst_license_status', 'hospital_details_history.license_status_id', '=', 'lst_license_status.id')

                ->select(
                    'hospital_details_history.*',
                    'ou_states.name as state',
                    'ou_lgas.name as lga',
                    'ou_wards.name as ward',

                    'lst_facility_types.name as facility_type_name',
                    'lst_level_of_care.name as facility_level_name',
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
                ->where('hospital_details_history.state_id', '=', Auth::user()->state_id)
                // ->whereIn('hospital_details_history.lga_id', auth()->user()->getDirectPermissions()->pluck('id')->toArray())
                ->whereIn('hospital_details_history.status_id', [2, 7, 9, 14, 16, 21])
                ->get();
        }

        return view('approvals.pending_validation', compact('pending'));
    }

    public function search(Request $request)
    {
        if ($request->status == 1) {
            if (auth()->user()->hasAnyPermission(['lga_1000'])) {
                $pending  = DB::table('hospital_details_history')
                    ->where('state_id', '=', Auth::user()->state_id)
                    ->where('action', 'like', '%' .  $request->action . '%')
                    ->whereIn('status_id', [2, 7, 9, 14, 16, 21])
                    ->get();
            } else {
                $pending  = DB::table('hospital_details_history')
                    ->where('state_id', '=', Auth::user()->state_id)
                    ->where('action', 'like', '%' .  $request->action . '%')
                    ->whereIn('lga_id', auth()->user()->getDirectPermissions()->pluck('id')->toArray())
                    ->whereIn('status_id', [2, 7, 9, 14, 16, 21])
                    ->get();
            }
        } elseif ($request->status == 2) {
            $pending = DB::table('hospital_details_history')
                ->where('validated_id', '=', Auth::user()->id)
                ->where('action', 'like', '%' .  $request->action . '%')
                ->whereIn('status_id', [4, 11, 18])
                ->get();
        } elseif ($request->status == 3) {
            $pending = DB::table('hospital_details_history')
                ->where('validated_id', '=', Auth::user()->id)
                ->where('action', 'like', '%' .  $request->action . '%')
                ->whereIn('status_id', [5, 12, 19])
                ->get();
        } else {
            $pending = DB::table('hospital_details_history')
                ->where('validated_id', '=', Auth::user()->id)
                ->where('action', 'like', '%' .  $request->action . '%')
                ->orderby('updated_at', 'desc')
                ->get();
        }

        $request->flash('request', $request);
        return view('approvals.pending_validation', compact('pending'));
    }

    public function store(Request $request)
    {
        if (!$this->isValidated($request->id)) {

            $date = Carbon::now()->format('Y-m-d H:i:s');

            HospitalHistory::disableAuditing();
            $hosp = new HospitalHistory();
            $hosp = HospitalHistory::findOrFail($request->id);

            $user = Auth::user();

     
            if ($request->action == "approve") {
                if ($request->requested_action == "CREATE FACILITY") {
                    $status_id = 4;
                    $message = "Facility Creation Validated";
                    $mail_message = "Facility creation request has been validated. Please login to the system to review and Publish the request.";
                } elseif ($request->requested_action == "UPDATE FACILITY") {
                    $status_id = 11;
                    $message = "Facility Update Validated";
                    $mail_message = "Facility update request has been validated. Please login to the system to review and Publish the request.";
                } else {
                    $status_id = 18;
                    $message = "Facility Deletion Validated";
                    $mail_message = "Facility deletion request has been validated. Please login to the system to review and Publish the request.";
                }

                //clear publish fields after reqest rejected at publish level and then re submiited
                $hosp->published_by = $request->published_by;
                $hosp->published_at = $request->published_at;
                $hosp->publish_note = $request->publish_note;
            }

            if ($request->action == "reject") {
                if ($request->requested_action == "CREATE FACILITY") {
                    $status_id = 5;
                    $message = "Facility Validation Rejected";
                    $mail_message = "Validator has rejected facility creation request. Please login to the system to review your request.";
                } elseif ($request->requested_action == "UPDATE FACILITY") {
                    $status_id = 12;
                    $message = "Facility Validation Rejected";
                    $mail_message = "Validator has rejected facility update request. Please login to the system to review your request.";
                } else {
                    $status_id = 19;
                    $message = "Facility Validation Rejected";
                    $mail_message = "Validator has rejected facility deletion request. Please login to the system to review your request.";
                }
            }


            $hosp->status_id = $status_id;

            $hosp->validated_by = $user->id;
            // $hosp->validated_id = $user->id;
            $hosp->validated_email = $user->email;
            $hosp->validated_mobile = $user->mobile;

            $hosp->validated_at = $date;
            $hosp->validate_note = $request->notes;

            $status = new StatusTracking;
            $status->hospital_id = $request->id;
            $status->user_id = $user->id;
            $status->status_id = $status_id;
            $status->note = $request->notes;
            $status->created_at = $date;

            DB::beginTransaction();
            try {
                $hosp->save();
                $status->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            HospitalHistory::enableAuditing();

            //****** send notifications *********
            if (config('hfr.notify_publisher')) {
                $notify = new ApprovalNotifications;
                $notify->sendValidationNotification($mail_message, $request->action);
            }


            session()->flash("alert-success", $message);

            if ($status_id == 11 or $status_id == 12) {
                return redirect()->route('validate.pending');
            } else {
                return redirect()->back();
            }
        } //end is not validated
        else {
            session()->flash("alert-success", 'The request is already validated');
            return redirect()->route('validate.pending');
        }
    }


    public function recall(Request $request)
    {
        if ($this->isValidated($request->hosp_id)) {

            if ($request->action == "CREATE FACILITY") {
                $status_id = 2;
                $action = "Recall Create Validation";
            } elseif ($request->action == "UPDATE FACILITY") {
                $status_id = 9;
                $action = "Recall Update Validation";
            } else {
                $status_id = 16;
                $action = "Recall Delete Validation";
            }

            HospitalHistory::disableAuditing();
            $hosp = new HospitalHistory;
            $hosp = HospitalHistory::findOrFail($request->hosp_id);
            $hosp->status_id = $status_id;
            $hosp->validated_by = $request->validated_by;
            $hosp->validated_at = $request->validated_at;
            $hosp->validate_note = $request->validate_note;

            $status = new StatusTracking;
            $status->hospital_id = $request->hosp_id;
            $status->user_id = Auth::user()->id;
            $status->status_id = $status_id;
            $status->created_at =  Carbon::now()->format('Y-m-d H:i:s');
            $status->note = $action;


            DB::beginTransaction();
            try {
                $hosp->save();
                $status->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json(['error' => $ex->getMessage()], 500);
            }

            HospitalHistory::enableAuditing();

            session()->flash("alert-success", "Validation recalled successfully!");
        } else {
            session()->flash("alert-success", "Can not recall validated or published request!");
        }

        return redirect()->route('validate.pending');
    }

    private function isValidated($id)
    {
        $hosp = HospitalHistory::find($id);

        if (in_array($hosp->status_id, [4, 11, 18])) {
            return true;
        } else {
            return false;
        }
    }
}
