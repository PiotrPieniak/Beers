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


Route::get('beers', 'BeerController@index')->middleware('cors');

Route::get('beer/{id}', 'BeerController@show')->middleware('cors');

Route::get('types', 'BeerController@types')->middleware('cors');

Route::get('countries', 'BeerController@countries')->middleware('cors');

Route::get('brewers', 'BrewerController@index')->middleware('cors');

