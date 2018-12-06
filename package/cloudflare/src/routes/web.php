<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['namespace' => 'Frank\Cloudflare\Http\Controllers', 'prefix' => 'cloudflare'], function(){
    Route::post('/domain/search/single','ProcessController@searchSingleDomain');
    Route::get('/','ProcessController@test');
    Route::get('/sites','ProcessController@getMySites');
    Route::post('/addsite','ProcessController@addSite');
    Route::post('/domain/search/multiple','ProcessController@searchMultipleDomains');
});

