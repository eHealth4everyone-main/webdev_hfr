<?php

use App\Http\Controllers\Frontend\API\FrontendController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//         return $request->user();
// });

Route::group(['middleware' => 'cors'], function () {

    Route::get('slider', [FrontendController::class, 'slider']);

    Route::get('origin', [FrontendController::class, 'origin']);
    Route::get('process', [FrontendController::class, 'process']);
    Route::get('process-item', [FrontendController::class, 'processItem']);
    Route::get('facility-type', [FrontendController::class, 'facilityType']);
    
    
    Route::get('facility-level', [FrontendController::class, 'facilityLevel']);
    
    Route::get('states', [FrontendController::class, 'states']);
    
    Route::post('lgas-by-state', [FrontendController::class, 'getLgaListByStateId']);
    Route::post('ward-by-lga', [FrontendController::class, 'getWardListByLGA']);
    
    Route::get('ownership', [FrontendController::class, 'getOwnership']);
    Route::post('ownership-type', [FrontendController::class, 'getOwnershipType']);
    
    Route::get('operational-status', [FrontendController::class, 'getOperationalStatus']);
    Route::get('registration-status', [FrontendController::class, 'getRegistrationStatus']);
    Route::get('license-status', [FrontendController::class, 'getLicenseStatus']);
    Route::get('service-category', [FrontendController::class, 'getServiceCategory']);
    Route::post('services-by-category', [FrontendController::class, 'getServicesByCategory']);
    
    Route::post('facilities-hospitals-search/{page?}', [FrontendController::class, 'searchHospitals']);



    Route::post('facilitiesbyLga', [FrontendController::class, 'getFacilitesByLGA']);
    Route::post('googlemap', [FrontendController::class, 'getFacilitesGMap']);

});
