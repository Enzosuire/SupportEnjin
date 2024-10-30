<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\Facturations\Http\Controllers'], function()
{

//Facturations
Route::get('/facturations/create', ['uses' =>'FacturationsController@create','middleware' => ['auth']])->name('facturations.createFa');
Route::post('/facturations/store', 'FacturationsController@store')->name('facturations.store');
Route::get('/facturations/{id_projet?}', ['uses' => 'FacturationsController@show', 'middleware' => ['auth']])->name('facturations.show');
Route::get('/facturations/update/{id_projet}/{id}', ['uses' => 'FacturationsController@update', 'middleware' => ['auth']])->name('facturations.updatefa');
Route::post('/facturations/update/traitement', ['uses' => 'FacturationsController@update_facturations_traitement','middleware' => ['auth']])->name('facturations.update_facturations_traitement');
Route::get('/facturations/delete/{id_projet}/{id}', ['uses' => 'FacturationsController@delete', 'middleware' => ['auth']])->name('facturations.delete');



});
