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
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => [
    'auth',
]], function () {
    Route::get('/set_page', 'GraphController@retrieveUserProfile')->name('set_page');

});
Route::get('/save_page', 'EntitiesController@CreateOrUpdatePage')->name('save_page');
