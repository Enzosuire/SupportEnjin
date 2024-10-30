<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\CustomCustomer\Http\Controllers'], function()
{

//Liste de tout les clients 
Route::get('/clients',['uses' => 'CustomCustomerController@Customerall','middleware' => ['auth']])->name('customers.Customerall');

Route::get('/customers/create', ['uses' => 'CustomCustomerController@create','middleware' => ['auth']])->name('customers.create');

Route::post('/customers/store', 'CustomCustomerController@store')->name('customers.store');



});
