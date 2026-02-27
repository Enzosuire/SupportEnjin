<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\Projet\Http\Controllers'], function()
{

//Projet
Route::get('/projet/create', ['uses' => 'ProjetController@create','middleware' => ['auth']])->name('projet.createpro');
Route::post('/projet/store', 'ProjetController@store')->name('projet.store');
Route::get('/projet/{id?}', ['uses' => 'ProjetController@show','middleware' => ['auth']])->name('projet.show');
Route::get('/projet/update/{customerId}/{id}',['uses' => 'ProjetController@update','middleware' => ['auth']])->name('projet.updatepro');
Route::post('/projet/update/traitement', ['uses' => 'ProjetController@update_projet_traitement','middleware' => ['auth']])->name('projet.update_projet_traitement');
Route::get('/projet/delete/{customerId}/{id}',['uses' =>  'ProjetController@delete' ,'middleware' => ['auth']])->name('projet.delete');

});
