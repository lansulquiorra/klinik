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

Route::get('/', 'ApiFrontController@welcome');
Route::get('/display', 'ApiFrontController@getDisplay');
Route::post('/kiosk/add', 'ApiFrontController@postKiosk');


Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['prefix' => 'common'], function () {
        /*list all model*/
        Route::get('/batches', 'GeneralController@getBatches');
        Route::get('/buyers', 'GeneralController@getBuyers');
        Route::get('/doctor-services', 'GeneralController@getDoctorServices');
        Route::get('/hospital', 'GeneralController@getHospital');
        Route::get('/icd10', 'GeneralController@getIcd10s');
        Route::get('/inventories', 'GeneralController@getInventories');
        Route::get('/kiosks', 'GeneralController@getKiosks');
        Route::get('/medical-records', 'GeneralController@getMedicalRecords');
        Route::get('/patiens', 'GeneralController@getPatients');
        Route::get('/payments', 'GeneralController@getPayments');
        Route::get('/permissions', 'GeneralController@getPermissions');
        Route::get('/pharmacy-seller', 'GeneralController@getPharmacySeller');
        Route::get('/polies', 'GeneralController@getPolies');
        Route::get('/recipes', 'GeneralController@getRecipes');
        Route::get('/references', 'GeneralController@getReferences');
        Route::get('/registers', 'GeneralController@getRegisters');
        Route::get('/roles', 'GeneralController@getRoles');
        Route::get('/services', 'GeneralController@getServices');
        Route::get('/settings', 'GeneralController@getSettings');
        Route::get('/staff-jobs', 'GeneralController@getStaffJobs');
        Route::get('/staff-positions', 'GeneralController@getStaffPositions');
        Route::get('/tuslahs', 'GeneralController@getTuslahs');
        Route::get('/users', 'GeneralController@getUsers');
        Route::get('/doctors', 'GeneralController@getDoctors');


        Route::get('/user-info', '\App\Http\Controllers\Common\ApiCommonController@info');
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['role:admin']], function () {
        Route::resource('doctor-services', 'ApiDoctorServiceController');
        Route::resource('permissions', 'ApiPermissionController');
        Route::resource('polies', 'ApiPolyController');
        Route::resource('roles', 'ApiRoleController');
        Route::resource('services', 'ApiServiceController');
        Route::resource('settings', 'ApiSettingController');
        Route::resource('staff', 'ApiStaffController');
        Route::resource('staff-jobs', 'ApiStaffJobController');
        Route::resource('staff-positions', 'ApiStaffPositionController');
        Route::resource('users', 'ApiUserController');

        /*common used*/
        Route::resource('queues', '\App\Http\Controllers\Common\ApiQueueController');
        Route::resource('registers', '\App\Http\Controllers\Common\ApiRegistrationController');
        Route::resource('check-up', '\App\Http\Controllers\Common\ApiCheckUpController');
        Route::resource('payments', '\App\Http\Controllers\Common\ApiPaymentController');
        Route::resource('recipes', '\App\Http\Controllers\Common\ApiRecipeController');
        Route::resource('inventories', '\App\Http\Controllers\Common\ApiInventoryController');
        Route::resource('visitors', '\App\Http\Controllers\Common\ApiVisitorController');
        Route::post('/profile', '\App\Http\Controllers\Common\ApiProfileController@postProfile');
    });

    Route::group(['prefix' => 'loket', 'namespace' => 'Loket', 'middleware' => ['role:loket|admin_loket']], function () {
        /*common used*/
        Route::resource('queues', '\App\Http\Controllers\Common\ApiQueueController');
        Route::resource('registers', '\App\Http\Controllers\Common\ApiRegistrationController');
    });

    Route::group(['prefix' => 'penata-jasa', 'namespace' => 'PenataJasa', 'middleware' => ['role:poli_umum|poli_anak|admin_poli_umum|admin_poli_anak']], function () {
        /*common used*/
        Route::resource('queues', '\App\Http\Controllers\Common\ApiQueueController');
        Route::resource('check-up', '\App\Http\Controllers\Common\ApiCheckUpController');
    });

    Route::group(['prefix' => 'kasir', 'namespace' => 'Kasir', 'middleware' => ['role:kasir|admin_kasir']], function () {
        Route::resource('payments', '\App\Http\Controllers\Common\ApiPaymentController');
    });

    Route::group(['prefix' => 'apotek', 'namespace' => 'Apotek', 'middleware' => ['role:apotek|admin_apotek']], function () {
        /*common used*/
        Route::resource('recipes', '\App\Http\Controllers\Common\ApiRecipeController');
        Route::resource('inventories', '\App\Http\Controllers\Common\ApiInventoryController');
    });

});