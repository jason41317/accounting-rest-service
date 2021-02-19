<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'AuthController@login');

    Route::group(['middleware' => ['auth:api']], function () {
        Route::get('/me', 'AuthController@getAuthUser');
        Route::post('/logout', 'AuthController@logout');
        Route::resource('/service-categories', 'ServiceCategoryController');
        Route::resource('/services', 'ServiceController');
        Route::resource('/document-types', 'DocumentTypeController');
        Route::resource('/business-styles', 'BusinessStyleController');
        Route::resource('/business-types', 'BusinessTypeController');
        Route::resource('/account-types', 'AccountTypeController');
        Route::resource('/account-classes', 'AccountClassController');
        Route::resource('/account-titles', 'AccountTitleController');
        Route::resource('/clients', 'ClientController');
        Route::resource('/contracts', 'ContractController');
        Route::resource('/charges', 'ChargeController');
        Route::resource('/billings', 'BillingController');
        Route::resource('/personnels', 'PersonnelController');
        Route::resource('/user-groups', 'UserGroupController');
        Route::resource('/rdos', 'RdoController');
        Route::resource('/locations', 'LocationController');
    });
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
