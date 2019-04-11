<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
        // Route::get('/hfr','apiController@index');
        // Route::post('post','apiController@store');
   
});

// Route::post('post','apiController@store');
// // Route::get('/hfr','apiController@index');

// Route::get('/hfr','apiController@collection');

// Route::get('/user', function (Request $request) {
//     $users= \App\User::all();
//         return response()->json([
//             "code"=>200,
//             "status"=>"success",
//             "message"=>"transaction was successful",
//             "DeveloperMessage"=>"the list of users was ftche3d sucessfully",
//             "data"=>["users"=>$users]
//         ],200); 
// });

