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
App::setLocale('ru');

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
	Route::get('/website/list', 'Admin\WebsiteController@index')->name('admin.website.list');
	Route::get('/website/edit/{websiteId}', 'Admin\WebsiteController@edit')->name('admin.website.edit');
	Route::get('/website/add/', 'Admin\WebsiteController@add')->name('admin.website.add');
});
Route::get('/', 'Generator\PageController@view')->name('generator.page.main');
Route::get('/404', 'Generator\PageController@notFoundPage')->name('generator.page.404');
Route::get('/{pageSlug}', 'Generator\PageController@view')->name('generator.page.view');


