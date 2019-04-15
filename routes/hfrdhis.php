<?php

Route::get('admin/hfr-dhis-exchange/index', 'HfrDhisController@index');
Route::post('admin/hfr-dhis-exchange/store', 'HfrDhisController@store')->name('dhis.store');
Route::post('admin/hfr-dhis-exchange/update', 'HfrDhisController@update')->name('dhis.update');
Route::get('admin/hfr-dhis-exchange/logs', 'HfrDhisController@logs')->name('dhis.logs');

Route::get('admin/hfr-dhis-exchange/test', 'HfrDhisController@test');