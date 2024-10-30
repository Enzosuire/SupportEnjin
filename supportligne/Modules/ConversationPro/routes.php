<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\ConversationPro\Http\Controllers'], function()
{


    Route::post('/conversation/={id}', 'ConversationProController@update')->name('conversationpro.update');
    // Route::post('/update/{id}', 'ConversationProController@update')->name('conversationpro.update');
  


});
