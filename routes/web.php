<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
*/
Route::get('/', 'HomeController@userhome')->name('home');
Route::get('/hospitals', 'FacilityListingController@hosptials')->name('listhosp');
Route::get('/facilitieslist', 'FacilityListingController@index')->name('getfacilities');
Route::get('/statistics', 'FacilityListingController@statistics')->name('statistics');
Route::get('/statisticscharts', 'FacilityListingController@statistics_charts')->name('statistics_charts');

Route::view('/about', 'public.about')->name('about');
Route::get('/hfrresources', 'ResourceController@public_index')->name('public_resources');
Route::get('/facilities', 'FacilityListingController@search')->name('search');
Route::get('/fdownload', 'DownloadController@DownloadForm')->name('downloadfm');
Route::post('/fdownload', 'DownloadController@store')->name('saveDownloadUser');
Route::get('/download', 'DownloadController@index')->name('download');
Route::get('/downloads', 'DownloadController@getFacilities')->name('facToDownload');
Route::get('/downloads/excel/{type}/{state}/{format}', 'DownloadController@export')->name('export');
Route::get('/contactus', 'ContactController@openContactForm')->name('open_contact_form');
Route::post('/contactus', 'ContactController@store')->name('storecontact');

Auth::routes();

Route::middleware(["auth"])->group(function(){

    Route::get('/admin', 'HomeController@adminhome')->name('admin_home');

    //equipments
    Route::get('/equipments','EquipmentController@index');

    //users and roles
    Route::get('/roles', 'RoleController@index');
    Route::post('/roles/add', 'RoleController@store')->name('addrole');
    Route::post('/roles/update', 'RoleController@update')->name('updaterole');
    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/register', 'UserController@create');
    Route::post('/users/register', 'UserController@store')->name("registeruser");
    Route::post('/users/update', 'UserController@update')->name("updateuser");
    Route::put('/users/del', 'UserController@deactivate')->name("delUser");


    //hospitals
    Route::resource('sign','SignatureController');
    Route::get('/sign/search','SignatureController@search')->name('sign.search');
    Route::post('/sign/fetchLga', 'SignatureController@fetchLga')->name('sign.fetchLga');
    Route::post('/sign/fetctWards', 'SignatureController@fetchWards')->name('sign.fetchWards');

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

});





