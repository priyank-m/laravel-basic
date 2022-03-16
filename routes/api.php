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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'RegistrationController@storeUser');
    Route::post('login', 'RegistrationController@authenticate');
    Route::get('open', 'DataController@open');

    Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('user', 'RegistrationController@getAuthenticatedUser');
        Route::get('closed', 'DataController@closed');
        Route::get('product', 'API\CategoryController@index');
    });
