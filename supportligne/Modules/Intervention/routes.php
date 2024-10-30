<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\Intervention\Http\Controllers'], function()
{

// Intervention
Route::get('/interventions/create',['uses' => 'InterventionController@createForm','middleware' => ['auth']])->name('intervention.create');
Route::post('/interventions/store', 'InterventionController@store')->name('intervention.store');
Route::get('/interventions/{id_projet?}',['uses' => 'InterventionController@show','middleware' => ['auth']])->name('intervention.show');
Route::get('/interventions/update/{customerId}/{id}', ['uses' => 'InterventionController@update', 'middleware' => ['auth']])->name('intervention.updateint');
Route::post('/interventions/update/traitement', ['uses' => 'InterventionController@update_interventions_traitement', 'middleware' => ['auth']])->name('intervention.update_interventions_traitement');
Route::get('/interventions/delete/{customerId}/{id}', ['uses' =>  'InterventionController@delete', 'middleware' => ['auth']])->name('intervention.delete');




});
