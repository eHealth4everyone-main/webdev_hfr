<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/

//home
Route::get('/', 'HomeController@index')->name('home');
Route::post('/home/facilitiesbyLga', 'HomeController@getFacilitesByLGA')->name('getFacilitesByLGA');
Route::post('/home/googlemap', 'HomeController@getFacilitesGMap')->name('getFacilitesGMap');

Route::view('/about', 'public.about')->name('about');
Route::get('/contactus', 'ContactController@openContactForm')->name('open_contact_form');
Route::post('/contactus', 'ContactController@store')->name('storecontact');

Route::get('/facilities/hospitals', 'FacilityListingController@index')->name('listhosp');
Route::get('/facilities/searchlist', 'FacilityListingController@searchFacilities')->name('searchFacilities');
Route::get('/facilities/hospitalssearch', 'FacilityListingController@searchHospitals')->name('searchHospitals');
Route::get('/facilities/details/{id}/{facility_type_id}','FacilityListingController@showDetails')->name('facilitydetails');

Route::get('/statistics/tables', 'SummaryTablesController@index')->name('statistics');
Route::get('/statistics/tables/filter', 'SummaryTablesController@filter')->name('filterStatistics');

Route::get('/statistics/charts', 'SummaryChartsController@index')->name('statistics_charts');
Route::get('/statistics/charts/filter', 'SummaryChartsController@filter')->name('filterStatisticsCharts');
Route::get('/statistics/populationindex', 'SummaryChartsController@population_index')->name('population_index');

Route::get('/hfrresources', 'ResourceController@public_index')->name('public_resources');
Route::get('/download/facilities', 'DownloadController@openRegistrationForm')->name('openRegistrationForm');
Route::post('/download/facilities', 'DownloadController@store')->name('saveDownloadUserRecords');
Route::get('/download/facilitylist', 'DownloadController@index')->name('downloadFacilitiesList');
Route::get('/download/filter', 'DownloadController@filter')->name('downloadFacilityFilter');
Route::get('/downloads/excel/{type}/{state}/{format}', 'DownloadController@export')->name('export');

//routes to populate lgas and wards
Route::post('/hosp/fetchLga', 'GeneralController@getLgaList')->name('getLgaList');
Route::post('/hosp/fetctWards', 'GeneralController@getWardList')->name('getWardList');

//resources
Route::get('/resources/download/{file}', 'ResourceController@download')->name('downloadFile');

Auth::routes();

Route::middleware(["auth"])->group(function(){

    Route::get('/admin', 'AdminHomeController@adminhome')->name('admin_home');

    //equipments
    Route::get('/equipments','EquipmentController@index');

    //roles
    Route::get('admin/roles', 'RoleController@index')->name('roles.index');
    Route::post('admin/roles/add', 'RoleController@store')->name('addrole');
    Route::post('admin/roles/update', 'RoleController@update')->name('updaterole');

    //users
    Route::get('admin/users', 'UserController@index')->name('users.index');
    Route::get('admin/users/register', 'UserController@create');
    Route::post('admin/users/register', 'UserController@store')->name("registeruser");
    Route::post('admin/users/update', 'UserController@update')->name("updateuser");
    Route::put('admin/users/del', 'UserController@deactivate')->name("delUser");
    Route::post('admin/changePassword','UserController@changePassword')->name('changePassword');
    Route::get('admin/profile','UserController@profile')->name('profile');
    Route::post('admin/profile/update', 'UserController@updateProfile')->name("updateProfile");

    //hospitals
    Route::resource('admin/hospitals','HospitalsController');
    Route::post('admin/hospitals/search','HospitalsController@search')->name('searchHospitalsAdmin');
    Route::get('admin/hospitals/services/{id}','HospitalsController@services')->name('hospitals.services');
    Route::post('admin/hospitals/services','HospitalsController@StoreServices')->name('hospitals.storeservices');


    
    //general
    Route::post('admin/facilities/ownership','GeneralController@getOwnershipType')->name('getOwnershipType');
    Route::post('admin/facilities/facilityleveloption','GeneralController@getFacilityLevelOption')->name('getFacilityLevelOption');
    Route::post('admin/facilities/facilityspecializedoption','GeneralController@getSpecializedOptions')->name('getSpecializedOptions');
   
   
    //laboratory
    Route::resource('admin/laboratory','LabController');
    Route::post('/lab/equips', 'LabController@fetchEquips')->name('lab.fetchEquips');
    Route::post('/lab/cert', 'LabController@fetchCert')->name('lab.fetchCert');

    //lab certification
    Route::get('/cert','CertificationController@index');

    //LGA and States
    Route::get('/lga','LgaController@index');
    Route::get('/states','StateController@index');

    //wards
    Route::get('admin/wards','WardController@index');
    Route::get('admin/wards/listwards','WardController@listWards')->name('wards.listwards');

    //Pharmacy
    Route::resource('admin/pharmacies','PharmacyController');

    //Imaging and Radiology premises
    Route::resource('admmin/imaging/service','ImagingServiceController');
    Route::resource('admin/imaging','ImagingController');
    Route::post('/admin/imaging/services', 'ImagingController@fetchServices')->name('imaging.fetchServices');
    

    //resources
    Route::get('/resources', 'ResourceController@index')->name('resources');
    Route::get('/resources/upload', 'ResourceController@upload')->name('upload');
    Route::post('/resources/uploads', 'ResourceController@store')->name('savefile');
    Route::post('/resources/delete/{file}', 'ResourceController@destroy')->name('deleteFile');
    

    //messages
    Route::get('admin/messages', 'ContactController@index')->name('getMessages');

    //download
    Route::get('admin/download/list', 'DownloadController@adminIndex')->name('downloadList');

});





