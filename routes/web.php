<?php


//home
Route::get('/', 'HomeController@index')->name('home');
Route::post('home/facilitiesbyLga', 'HomeController@getFacilitesByLGA')->name('getFacilitesByLGA');
Route::post('home/googlemap', 'HomeController@getFacilitesGMap')->name('getFacilitesGMap');
Route::post('home/googlemap/facilitydetails', 'HomeController@getFacilityDetails')->name('getFacilityDetails');

Route::get('about', 'HomeController@about')->name('about');

Route::get('contactus', 'ContactController@openContactForm')->name('open_contact_form');
Route::post('contactus', 'ContactController@store')->name('storecontact');

Route::get('facilities/hospitals-list', 'FacilityListingController@getHospitals')->name('list.hospitals');
Route::get('facilities/hospitals-search', 'FacilityListingController@searchHospitals')->name('search.hospitals');
Route::get('facilities/pharmacies-list', 'FacilityListingController@getPharmacy')->name('list.pharmacy');
Route::get('facilities/pharmacies-search', 'FacilityListingController@searchPharmacy')->name('search.pharmacy');
Route::get('facilities/laboratory-list', 'FacilityListingController@getLab')->name('list.laboratory');
Route::get('facilities/laboratory-search', 'FacilityListingController@searchLab')->name('search.laboratory');
Route::get('facilities/imaging-list', 'FacilityListingController@getImaging')->name('list.imaging');
Route::get('facilities/imaging-search', 'FacilityListingController@searchImaging')->name('search.imaging');

Route::get('facilities/latest-updates/view', 'FacilityListingController@getUpdates')->name('view.updates');
Route::get('facilities/latest-updates', 'FacilityListingController@updates')->name('latest.updates');
Route::get('facilities/hospital-search', 'FacilityListingController@searchHospital')->name('searchHospitals');



//summary tables
Route::get('statistics/tables', 'SummaryTablesController@index')->name('statistics');
Route::get('statistics/tables/filter', 'SummaryTablesController@filter')->name('filterStatistics');

//summary charts
Route::get('statistics/charts', 'SummaryChartsController@index')->name('statistics_charts');
Route::post('statistics/charts/filter', 'SummaryChartsController@filter')->name('filterStatisticsCharts');
Route::get('statistics/populationindex', 'SummaryChartsController@population_index')->name('population_index');
Route::post('statistics/populationindex/filter', 'SummaryChartsController@population_index_filter')->name('population_filter');


//download facilies
Route::get('download/facilities', 'DownloadController@openRegistrationForm')->name('openRegistrationForm');
Route::post('download/facilities', 'DownloadController@store')->name('saveDownloadUserRecords');
Route::get('download/facility-list', 'DownloadController@index')->name('downloadFacilitiesList');
Route::get('download/export-data', 'DownloadController@export')->name('download.export');
Route::get('download/validate', 'DownloadController@getValidationForm')->name('getValidateForm');
Route::post('download/validate', 'DownloadController@validateToken')->name('validateToken');


//routes to populate lgas and wards
Route::post('hosp/fetchLga', 'GeneralController@getLgaList')->name('getLgaList');
Route::post('hosp/fetctWards', 'GeneralController@getWardList')->name('getWardList');

Route::post('hosp/services', 'GeneralController@getServices')->name('getServices');


Route::post('hospitals/servicesavailable','HospitalsController@getservices')->name('hospitals.getServices');
Route::post('hospitals/servicesavailable/history','HospitalsController@getservicesHistory')->name('hospitals.getServicesHistory');


//resources
Route::get('resources/download/{file}', 'ResourceController@download')->name('downloadFile');
Route::get('resources', 'ResourceController@public_index')->name('public_resources');

//to factor token
Route::get('login/token', 'Auth\TokenController@getToken');
Route::post('login/token', 'Auth\TokenController@postToken')->name('login.token');


Auth::routes();

Route::middleware(["auth"])->group(function(){

    Route::middleware(["newuser"])->group(function () {

            Route::get('administrator', 'AdminHomeController@index')->name('admin_home');

            //roles
            Route::get('admin/roles', 'RoleController@index')->name('roles.index');
            Route::get('admin/roles/create', 'RoleController@create')->name('roles.create');
            Route::post('admin/roles', 'RoleController@store')->name('roles.store');
            Route::get('admin/roles/{id}/edit', 'RoleController@edit')->name('roles.edit');
            Route::post('admin/roles/update', 'RoleController@update')->name('roles.update');

            //users
            Route::get('admin/users', 'UserController@index')->name('users.index');
            Route::get('admin/users/register', 'UserController@create');
            Route::post('admin/users/register', 'UserController@store')->name("registeruser");
            Route::post('admin/users/update', 'UserController@update')->name("updateuser");
            Route::put('admin/users/del', 'UserController@deactivate')->name("delUser");
            Route::post('admin/changepassword','UserController@changePassword')->name('changePassword');
            Route::get('admin/profile','UserController@profile')->name('profile');
            Route::post('admin/profile/update', 'UserController@updateProfile')->name("updateProfile");
     

            //hospitals
            Route::get('admin/hospitals/search','HospitalsController@search')->name('searchHospitalsAdmin');
            Route::post('admin/hospitals/delete','HospitalsController@InitiateDelete')->name('hospitals.InitiateDelete');
            Route::post('admin/hospitals/export', 'HospitalsController@export')->name('hospitals.export');
            Route::resource('admin/hospitals','HospitalsController')->except(['show','destroy']);

            //my requests
            Route::get('admin/hospitals/myrequest/pending','Approval\MyRequestController@myPendingRequest')->name('myrequest.pending');
            Route::get('admin/hospitals/myrequest/approved','Approval\MyRequestController@myApprovedRequest')->name('myrequest.approved');
            Route::get('admin/hospitals/myrequest/rejected','Approval\MyRequestController@myRejectedRequest')->name('myrequest.rejected');
            Route::get('admin/hospitals/myrequest/update/{id}','Approval\MyRequestController@editRequest')->name('myrequest.edit');
            Route::put('admin/hospitals/myrequest/updates','Approval\MyRequestController@updateRequest')->name('myrequest.update');
            Route::post('admin/hospitals/myrequest/delete','Approval\MyRequestController@deleteRequest')->name('myrequest.delete');
            Route::post('admin/hospitals/myrequest/delete-resubmit','Approval\MyRequestController@resubmit')->name('myrequest.resubmit');

            //approvals
            Route::get('admin/hospitals/approvals/verify','Approval\VerifyController@index')->name('verify.pending');
            Route::post('admin/hospitals/approvals/verify','Approval\VerifyController@store')->name('verify.store');
            Route::post('admin/hospitals/approvals/verify-recall','Approval\VerifyController@recall')->name('verify.recall');
            Route::get('admin/hospitals/approvals/validation','Approval\ValidateController@index')->name('validate.pending');
            Route::post('admin/hospitals/approvals/validation','Approval\ValidateController@store')->name('validate.store');
            Route::post('admin/hospitals/approvals/validation-recall','Approval\ValidateController@recall')->name('validate.recall');
            Route::get('admin/hospitals/approvals/publish','Approval\PublishController@index')->name('publish.pending');
            Route::post('admin/hospitals/approvals/publish','Approval\PublishController@store')->name('publish.store');
            Route::get('admin/hospitals/approvals/updated/{id}/{stage}','Approval\UpdatedRecordsController@updatedRecords')->name('view.updated_records');

            Route::get('admin/notifications','NotificationController@markAllAsRead')->name('notification.markAsRead');


            //general
            Route::post('admin/facilities/ownership','GeneralController@getOwnershipType')->name('getOwnershipType');
            Route::post('admin/facilities/facility-level-option','GeneralController@getFacilityLevelOption')->name('getFacilityLevelOption');
            Route::post('admin/facilities/facilitys-pecialized-option','GeneralController@getSpecializedOptions')->name('getSpecializedOptions');
        
            //laboratory
            Route::get('admin/laboratory/search','LabController@search')->name('laboratory.search');
            Route::resource('admin/laboratory','LabController')->except(['show']);
            
            //Pharmacy
            Route::get('admin/pharmacies/search','PharmacyController@search')->name('pharmacy.search');
            Route::resource('admin/pharmacies','PharmacyController')->except(['show']);

            //Imaging and Radiology premises
            Route::get('admin/imaging/search','ImagingController@search')->name('imaging.search');
            Route::resource('admin/imaging','ImagingController')->except(['show']);
       
            //resources
            Route::get('admin/resources', 'ResourceController@index')->name('resources');
            Route::get('admin/resources/upload', 'ResourceController@upload')->name('upload');
            Route::post('admin/resources/uploads', 'ResourceController@store')->name('savefile');
            Route::post('admin/resources/delete', 'ResourceController@destroy')->name('deleteFile');
            Route::post('admin/resources/edit','ResourceController@update')->name('updateResource');

            //messages
            Route::get('admin/messages', 'ContactController@index')->name('getMessages');

            //download
            Route::get('admin/download/list', 'DownloadController@guestDownloadRequests')->name('downloadList');

            //** ***** masters routes ******** */
            Route::resource('admin/masters/imaging-services','ImagingServiceController');
            Route::resource('admin/masters/hospital-services','HospitalServiceController');
            Route::resource('admin/masters/equipments','EquipmentController');
            Route::resource('admin/masters/certifications','CertificationController');
            Route::resource('admin/masters/states','StateController');
            Route::resource('admin/masters/lgas','LgaController');
            Route::resource('admin/masters/wards','WardController');
    });

    Route::get('admin/new-user/change-password','UserController@newUserChangePasswordForm')->name('newuser.PasswordForm');
    Route::post('admin/new-user/change-password','UserController@newUserChangePassword')->name('newuser.ChangePassword');

});

