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

        Route::post('register', 'API\RegistrationController@storeUser');
        Route::post('login', 'API\RegistrationController@authenticate');
        Route::get('open', 'API\DataController@open');

        Route::group(['middleware' => ['jwt.verify']], function() {
        Route::get('user', 'API\RegistrationController@getAuthenticatedUser');
        Route::get('closed', 'API\DataController@closed');
        Route::get('logout', 'API\RegistrationController@logout');

        Route::prefix('product')->group(function () {
            Route::get('/', 'API\ProductController@index');
            Route::post('/', 'API\ProductController@storeProduct');
            Route::get('/edit', 'API\ProductController@edit');
            Route::get('/delete', 'API\ProductController@delete');
        });
        
        Route::prefix('category')->group(function () {
            Route::get('/', 'API\CategoryController@index');
        Route::post('/', 'API\CategoryController@storeCategory');
        Route::get('/edit', 'API\CategoryController@edit');
        Route::get('/delete', 'API\CategoryController@delete');
        });

    });
