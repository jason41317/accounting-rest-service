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
        Route::post('/check-if-authorize', 'AuthController@checkIfAuthorize');
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
        Route::get('contracts/{contractId}/history', 'ContractController@getContractHistory');
        Route::resource('/charges', 'ChargeController');
        Route::resource('/billings', 'BillingController');
        Route::post('/billings/batch', 'BillingController@batchStore');
        Route::resource('/personnels', 'PersonnelController');
        Route::resource('/user-groups', 'UserGroupController');
        Route::resource('/rdos', 'RdoController');
        Route::resource('/locations', 'LocationController');
        Route::resource('/tax-types', 'TaxTypeController');
        Route::resource('/banks', 'BankController');
        Route::resource('/e-wallets', 'EwalletController');
        Route::resource('/disbursements', 'DisbursementController');
        Route::get('payments/yearly-comparison', 'PaymentController@yearlyComparison');
        Route::get('payments/collection-breakdown', 'PaymentController@collectionBreakdown');
        Route::resource('payments','PaymentController');
        Route::resource('permission-groups','PermissionGroupController');
        Route::resource('company-settings','CompanySettingController');
        Route::resource('closed-billing-periods', 'ClosedBillingPeriodController');
        Route::resource('journal-entries', 'JournalEntryController');

        //reports
        Route::get('billing-statement/{billingId}','ReportController@billingStatement');
        Route::get('disbursement/{disbursementId}','ReportController@chequeVoucher');


        //personnel photo
        Route::post('personnels/{personnelId}/photos','PersonnelPhotoController@store');
        Route::delete('personnels/{personnelId}/photos','PersonnelPhotoController@destroy');

        //company setting logo photo
        Route::post('company-settings/{companySettingId}/logos', 'CompanySettingLogoController@store');
        Route::delete('company-settings/{companySettingId}/logos', 'CompanySettingLogoController@destroy');

        //system setting
        Route::resource('system-settings','SystemSettingController');

        //billing period
        Route::patch('billing-periods/{id}/activate','BillingPeriodController@setActive');
        Route::resource('billing-periods','BillingPeriodController');

        //credit memo
        Route::resource('credit-memos', 'CreditMemoController');
        Route::get('credit-memos/{creditMemoId}/charges', 'CreditMemoController@charges');
        //tax fund
        Route::resource('tax-funds', 'TaxFundController');
        //audits
        Route::resource('audits', 'AuditController');

        //client change password
        Route::put('clients/{id}/change-password', 'ClientController@changePassword');
    });

    Route::get('collection-summary','ReportController@collectionSummary');
    Route::get('collection-detailed','ReportController@collectionDetailed');
    Route::get('client-subsidiary-ledger', 'ReportController@clientSubsidiaryLedger');
    Route::get('accounts-receivable-report', 'ReportController@accountsReceivableReport');
    Route::get('financial-position', 'ReportController@financialPosition');
    Route::get('income-statement', 'ReportController@incomeStatement');
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


