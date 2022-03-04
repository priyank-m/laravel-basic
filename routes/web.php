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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','logincontroller@login');
Route::post('login','logincontroller@checkLogin');
Route::get('registration','RegistrationController@index');
Route::post('registration','RegistrationController@storeUser');
Route::get('dashboard','Dashboard@dashboard');
Route::get('logout', 'logincontroller@logout');