<?php

use Illuminate\Support\Facades\Route;
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
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){

// Authentication routes
Route::get('auth/login', 'Auth\AuthController@index')->name('login');
Route::post('auth/login', 'Auth\AuthController@login')->name('loginEntry');
Route::get('auth/logout', 'Auth\AuthController@logout')->name('logout');

// Registration routes
Route::get('auth/register', 'Auth\AuthController@register')->name('register');
Route::post('auth/register', 'Auth\AuthController@store')->name('store');

// ForgetPass routes
Route::get('password/reset', 'Auth\ResetPassController@getEmail')->name('getEmail');
Route::post('password/reset', 'Auth\ResetPassController@sendEmail')->name('sendEmail');

// Create Reset Password Routes
Route::get('password/recovery/{token}', 'Auth\ResetPassController@getPassword');
Route::post('password/recovery', 'Auth\ResetPassController@updatePassword')->name('resetPassword');

/** End Authentication Controller **/

Route::group(['namespace'=>'Admin','as'=>'admin.', 'prefix'=>'admin', 'middleware'=> 'auth'], function()
{
    Route::get('/', 'IndexController@index')->name('adminIndex');
    Route::resource('/users', 'UserController');
});

Route::group(['namespace' => 'front'], function () {
    Route::get('/', 'IndexController@index')->name('front.index');

});

Route::get('/redirect/{service}', 'SocialiteController@redirect');
Route::get('/callback/{service}', 'SocialiteController@callback');



});
