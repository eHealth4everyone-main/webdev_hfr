<?php

use Illuminate\Support\Facades\DB;

function getStates(){
    return DB::table('ou_states')
    ->select('id','name')
    ->orderByRaw('name ASC')
    ->get();
}

function getOwnership(){
    return DB::table('lst_ownerships')
            ->select('id','name')
            ->get();
}

function getFacilityTypes(){
    return DB::table('lst_facility_types')
    ->select('id','name')
    ->get();
}

function getLevelOfCare(){
    return DB::table('lst_level_of_care')
    ->select('id','name')
    ->get();
}

function getOperationalStatus(){
    return DB::table('lst_oparational_status')
    ->select('id','status')
    ->where('category','1')
    ->get();
}

function getRegistrationStatus(){
    return DB::table('lst_registration_status')
    ->select('id','status')
    ->get();
}

function getLicenseStatus(){
    return DB::table('lst_license_status')
    ->select('id','status')
    ->get();
}

function getServiceCategory(){
    return DB::table('lst_hosp_service_category')
    ->get();
}

