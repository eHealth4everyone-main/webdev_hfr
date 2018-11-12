<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
Route::get('/', 'HomeController@index')->name('home');
Route::view('/about', 'public.about')->name('about');
Route::get('/contactus', 'ContactController@openContactForm')->name('open_contact_form');
Route::post('/contactus', 'ContactController@store')->name('storecontact');

Route::get('/facilities/hospitals', 'FacilityListingController@index')->name('listhosp');
Route::get('/facilities/searchlist', 'FacilityListingController@searchFacilities')->name('searchFacilities');
Route::get('/facilities/hospitalssearch', 'FacilityListingController@searchHospitals')->name('searchHospitals');
Route::get('/statistics/tables', 'SummaryTablesController@index')->name('statistics');
Route::get('/statistics/charts', 'SummaryChartsController@index')->name('statistics_charts');
Route::get('/statistics/populationindex', 'SummaryChartsController@population_index')->name('population_index');

Route::get('/hfrresources', 'ResourceController@public_index')->name('public_resources');
Route::get('/fdownload', 'DownloadController@DownloadForm')->name('downloadfm');
Route::post('/fdownload', 'DownloadController@store')->name('saveDownloadUser');
Route::get('/download', 'DownloadController@index')->name('download');
Route::get('/downloads', 'DownloadController@getFacilities')->name('facToDownload');
Route::get('/downloads/excel/{type}/{state}/{format}', 'DownloadController@export')->name('export');

//routes to populate lgas and wards
Route::post('/hosp/fetchLga', 'GeneralController@getLgaList')->name('getLgaList');
Route::post('/hosp/fetctWards', 'GeneralController@getWardList')->name('getWardList');
Route::post('/home/facilitiesbyLga', 'HomeController@getFacilitesByLGA')->name('getFacilitesByLGA');
Route::post('/home/googlemap', 'HomeController@getFacilitesGMap')->name('getFacilitesGMap');

Auth::routes();

Route::middleware(["auth"])->group(function(){

    Route::get('/admin', 'AdminHomeController@adminhome')->name('admin_home');

    //equipments
    Route::get('/equipments','EquipmentController@index');

    //roles
    Route::get('/roles', 'RoleController@index');
    Route::post('/roles/add', 'RoleController@store')->name('addrole');
    Route::post('/roles/update', 'RoleController@update')->name('updaterole');

    //users
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/register', 'UserController@create');
    Route::post('/users/register', 'UserController@store')->name("registeruser");
    Route::post('/users/update', 'UserController@update')->name("updateuser");
    Route::put('/users/del', 'UserController@deactivate')->name("delUser");
    Route::post('/changePassword','UserController@changePassword')->name('changePassword');
    Route::get('/profile','UserController@profile')->name('profile');
    Route::post('/profile/update', 'UserController@updateProfile')->name("updateProfile");

    //hospitals
    Route::resource('hosp','HospitalsController');
    Route::get('/hosp/search','HospitalsController@search')->name('hosp.search');
   

    //laboratory
    Route::resource('lab','LabController');
    Route::post('/lab/equips', 'LabController@fetchEquips')->name('lab.fetchEquips');
    Route::post('/lab/cert', 'LabController@fetchCert')->name('lab.fetchCert');

    //lab certification
    Route::get('/cert','CertificationController@index');

    //LGA and States
    Route::get('/lga','LgaController@index');
    Route::get('/states','StateController@index');

    //wards
    Route::get('/wards','WardController@index');
    Route::get('/wards/listwards','WardController@listWards')->name('wards.listwards');

    //Pharmacy
    Route::resource('pharma','PharmaController');

    //Imaging and Radiology premises
    Route::resource('iservice','ImagingServiceController');
    Route::resource('imaging','ImagingController');
    Route::post('/imaging/services', 'ImagingController@fetchServices')->name('imaging.fetchServices');
    

    //resources
    Route::get('/resources', 'ResourceController@index')->name('resources');
    Route::get('/resources/upload', 'ResourceController@upload')->name('upload');
    Route::post('/resources/uploads', 'ResourceController@store')->name('savefile');
    Route::post('/resources/delete/{file}', 'ResourceController@destroy')->name('deleteFile');
    Route::get('/resources/download/{file}', 'ResourceController@download')->name('downloadFile');

    //messages
    Route::get('/messages', 'ContactController@index')->name('messages');

    //download
    Route::get('/download/list', 'DownloadController@adminIndex')->name('downloadList');

});





