<?php


Route::get('admin/hfr-dhis/index', 'HfrDhisController@index');
Route::post('admin/hfr-dhis/store', 'HfrDhisController@store')->name('dhis.store');

Route::get('admin/hfr-dhis/test', 'HfrDhisController@test');



