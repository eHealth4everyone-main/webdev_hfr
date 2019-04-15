<?php

require base_path('routes/public.php');

Auth::routes();

Route::middleware(["auth"])->group(function(){

    Route::middleware(["newuser"])->group(function () {

            Route::get('administrator', 'AdminHomeController@index')->name('admin_home');

            require base_path('routes/hfrdhis.php');

            //roles
            Route::get('admin/roles', 'RoleController@index')->name('roles.index');
            Route::get('admin/roles/create', 'RoleController@create')->name('roles.create');
            Route::post('admin/roles', 'RoleController@store')->name('roles.store');
            Route::get('admin/roles/{id}/edit', 'RoleController@edit')->name('roles.edit');
            Route::post('admin/roles/update', 'RoleController@update')->name('roles.update');
            Route::delete('admin/roles/delete', 'RoleController@destroy')->name("roles.destroy");


            //users
            Route::get('admin/users', 'UserController@index')->name('users.index');
            Route::get('admin/users/register', 'UserController@create');
            Route::post('admin/users/register', 'UserController@store')->name("registeruser");
            Route::post('admin/users/update', 'UserController@update')->name("updateuser");
            Route::put('admin/users/delete', 'UserController@delete')->name("deleteUser");
            Route::put('admin/users/block', 'UserController@block')->name("blockUser");
            Route::post('admin/changepassword','UserController@changePassword')->name('changePassword');
            Route::get('admin/profile','UserController@profile')->name('profile');
            Route::post('admin/profile/update', 'UserController@updateProfile')->name("updateProfile");
            Route::get('admin/users/search', 'UserController@search')->name("users.search");
            Route::post('admin/users/role', 'UserController@getRoleID')->name('getRoleID');

     

            //hospitals
            Route::get('admin/hospitals/search','HospitalsController@search')->name('searchHospitalsAdmin');
            Route::post('admin/hospitals/delete','HospitalsController@InitiateDelete')->name('hospitals.InitiateDelete');
            Route::post('admin/hospitals/export', 'HospitalsController@export')->name('hospitals.export');
            Route::resource('admin/hospitals','HospitalsController')->except(['show','destroy']);
            
            //my requests
            Route::get('admin/hospitals/myrequest/pending','Approval\MyRequestController@myPendingRequest')->name('myrequest.pending');
            // Route::get('admin/hospitals/myrequest/approved','Approval\MyRequestController@myApprovedRequest')->name('myrequest.approved');
            // Route::get('admin/hospitals/myrequest/rejected','Approval\MyRequestController@myRejectedRequest')->name('myrequest.rejected');
            Route::get('admin/hospitals/myrequest/update/{id}','Approval\MyRequestController@editRequest')->name('myrequest.edit');
            Route::put('admin/hospitals/myrequest/updates','Approval\MyRequestController@updateRequest')->name('myrequest.update');
            Route::post('admin/hospitals/myrequest/delete','Approval\MyRequestController@deleteRequest')->name('myrequest.delete');
            Route::post('admin/hospitals/myrequest/delete-resubmit','Approval\MyRequestController@resubmit')->name('myrequest.resubmit');
            Route::get('admin/hospitals/myrequest/show','Approval\MyRequestController@search')->name('myrequest.search');

            //approvals
            Route::get('admin/hospitals/approvals/verify','Approval\VerifyController@index')->name('verify.pending');
            Route::post('admin/hospitals/approvals/verify','Approval\VerifyController@store')->name('verify.store');
            Route::post('admin/hospitals/approvals/verify-recall','Approval\VerifyController@recall')->name('verify.recall');
            Route::get('admin/hospitals/approvals/verify/show','Approval\VerifyController@search')->name('verify.search');

            Route::get('admin/hospitals/approvals/validation','Approval\ValidateController@index')->name('validate.pending');
            Route::post('admin/hospitals/approvals/validation','Approval\ValidateController@store')->name('validate.store');
            Route::post('admin/hospitals/approvals/validation-recall','Approval\ValidateController@recall')->name('validate.recall');
            Route::get('admin/hospitals/approvals/validation/show','Approval\ValidateController@search')->name('validate.search');

            Route::get('admin/hospitals/approvals/publish','Approval\PublishController@index')->name('publish.pending');
            Route::post('admin/hospitals/approvals/publish','Approval\PublishController@store')->name('publish.store');
            Route::get('admin/hospitals/approvals/publish/show','Approval\PublishController@search')->name('publish.search');

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
            Route::get('admin/download/list', 'DownloadController@DownloadRequests')->name('download.requests');

            //** ***** masters routes ******** */
            Route::resource('admin/masters/imaging-services','ImagingServiceController');
            Route::resource('admin/masters/hospital-services','HospitalServiceController');
            Route::resource('admin/masters/equipments','EquipmentController');
            Route::resource('admin/masters/certifications','CertificationController');
            Route::resource('admin/masters/states','StateController');
            Route::resource('admin/masters/lgas','LgaController');
            Route::get('admin/masters/wards/search','WardController@search')->name('wards.search');
            Route::resource('admin/masters/wards','WardController');


            //reports
            Route::get('admin/reports/facility-list/updates-select','FacilityReportController@updateSelection')->name('updates.selection');
            Route::get('admin/reports/facility-list/updates','FacilityReportController@getUpdatesReport')->name('updates.report');
            Route::post('admin/reports/facility-list/updates-download','FacilityReportController@updatesDownload')->name('updates.download');
            Route::get('admin/reports/facility-services/list','FacilityReportController@servicesIndex')->name('services.index');
            Route::get('admin/reports/facility-services/report','FacilityReportController@getServicesReport')->name('services.report');
            Route::post('admin/reports/facility-services/download','FacilityReportController@servicesDownload')->name('services.download');
            Route::get('admin/reports/facility-status/list','FacilityReportController@statusIndex')->name('status.index');
            Route::get('admin/reports/facility-status/report','FacilityReportController@getStatusReport')->name('status.report');
            Route::post('admin/reports/facility-status/download','FacilityReportController@statusDownload')->name('status.download');

    });

    Route::get('admin/new-user/change-password','UserController@newUserChangePasswordForm')->name('newuser.PasswordForm');
    Route::post('admin/new-user/change-password','UserController@newUserChangePassword')->name('newuser.ChangePassword');

});

