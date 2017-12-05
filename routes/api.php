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
    return $request->user();
});
Route::get('/website/get/{websiteId}', 'Admin\ApiWebsiteController@get')->name('api.admin.website.edit');
Route::post('/website/save/{websiteId}', 'Admin\ApiWebsiteController@save')->name('api.admin.website.save');
Route::post('/website/add/', 'Admin\ApiWebsiteController@add')->name('api.admin.website.add');
Route::get('/website/get/{websiteId}', 'Admin\ApiWebsiteController@get')->name('api.admin.website.edit');
Route::get('/website/regenerate/pages/{websiteId}', 'Admin\ApiWebsiteController@regeneratePages')->name('api.admin.website.regeneratePages');