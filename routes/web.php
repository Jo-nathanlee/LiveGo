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

Route::get('/login/facebook', 'Auth\LoginController@redirectToFacebookProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderFacebookCallback');
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => [
    'auth',
]], function () {
    Route::get('/set_page', 'GraphController@retrieveUserProfile')->name('set_page');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/index_load', 'GraphController@index_load');
    Route::get('/index_show', 'GraphController@index_show');
    Route::get('/save_page', 'EntitiesController@CreateOrUpdatePage')->name('save_page');
});

//ajax
Route::get('/update_message', 'GraphController@update_message');
Route::post('/update_message', 'GraphController@update_message');

Route::get('/start_record', 'GraphController@start_record');
Route::post('/start_record', 'GraphController@start_record');

Route::get('/end_record', 'GraphController@end_record');
Route::post('/end_record', 'GraphController@end_record');

Route::get('/end_record_top_price', 'GraphController@end_record_top_price');
Route::post('/end_record_top_price', 'GraphController@end_record_top_price');

Route::get('/store_streaming_order', 'GraphController@store_streaming_order');
Route::post('/store_streaming_order', 'GraphController@store_streaming_order');

Route::get('/add_comment', 'GraphController@add_comment');
Route::post('/add_comment', 'GraphController@add_comment');
