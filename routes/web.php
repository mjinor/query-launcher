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

Route::get('/', function () {
    return view('welcome');
});

Route::group(["middleware" => ['auth:sanctum', 'verified'],"prefix" => "/dashboard"],function () {

    Route::get('/', 'QueryController@index')->name('dashboard');

    Route::get('/execute', 'QueryController@dynamicExecute')->name('dynamic-execute');

    Route::group(["prefix" => "/query"],function () {

        Route::get('/find-book-by-ref-id','BookController@findByRefId');

        Route::get('/refund','BookController@fetchFactor');

        Route::get('/cancel-delete','BookController@cancelDelete');

        Route::get('/expired-to-paid','FactorController@expiredToPaid');

        Route::get('/find-doctor-by-medical-code','UserController@findByMedicalCode');

    });

});
