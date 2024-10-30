<?php

// Backend
Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\KnowledgeBase\Http\Controllers'], function()
{
    // Admin.
    Route::get('/mailbox/{mailbox_id}/knowledge-base', ['uses' => 'KnowledgeBaseController@settings'])->name('mailboxes.knowledgebase.settings');
    Route::post('/mailbox/{mailbox_id}/knowledge-base', ['uses' => 'KnowledgeBaseController@settingsSave']);
    Route::get('/mailbox/{mailbox_id}/knowledge-base/categories', ['uses' => 'KnowledgeBaseController@categories'])->name('mailboxes.knowledgebase.categories');
    Route::post('/mailbox/{mailbox_id}/knowledge-base/categories', ['uses' => 'KnowledgeBaseController@categoriesSave']);
    Route::get('/mailbox/{mailbox_id}/knowledge-base/articles/{category_id?}', ['uses' => 'KnowledgeBaseController@articles'])->name('mailboxes.knowledgebase.articles');
    Route::get('/mailbox/{mailbox_id}/knowledge-base/new-article/{category_id?}', ['uses' => 'KnowledgeBaseController@article'])->name('mailboxes.knowledgebase.new_article');
    Route::post('/mailbox/{mailbox_id}/knowledge-base/new-article/{category_id?}', ['uses' => 'KnowledgeBaseController@articleCreate']);
    Route::get('/mailbox/{mailbox_id}/knowledge-base/article/{article_id?}', ['uses' => 'KnowledgeBaseController@article'])->name('mailboxes.knowledgebase.article');
    Route::post('/mailbox/{mailbox_id}/knowledge-base/article/{article_id}', ['uses' => 'KnowledgeBaseController@articleSave']);
    Route::post('/knowledge-base/ajax-admin', ['uses' => 'KnowledgeBaseController@ajaxAdmin', 'laroute' => true])->name('mailboxes.knowledgebase.ajax_admin');

    // User.
    Route::get('/knowledge-base/ajax_html/{action}', ['uses' => 'KnowledgeBaseController@ajaxHtml', 'laroute' => true, 'middleware' => ['auth', 'roles'], 'roles' => ['user', 'admin']])->name('knowledgebase.ajax_html');
});

// Frontend
Route::group(['middleware' => [\App\Http\Middleware\EncryptCookies::class, \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, \Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class, \App\Http\Middleware\VerifyCsrfToken::class, \Illuminate\Routing\Middleware\SubstituteBindings::class, \App\Http\Middleware\HttpsRedirect::class, \App\Http\Middleware\Localize::class, \App\Http\Middleware\FrameGuard::class, \Modules\KnowledgeBase\Http\Middleware\CustomDomain::class], 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\KnowledgeBase\Http\Controllers'], function()
{
    // Customer
    Route::get('/hc/{mailbox_id}/auth', 'KnowledgeBaseController@customerLogin')->name('knowledgebase.customer_login');
    Route::get('/{kb_locale}/hc/{mailbox_id}/auth', 'KnowledgeBaseController@customerLoginI18n')->name('knowledgebase.customer_login_i18n');
    Route::post('/hc/{mailbox_id}/auth/logout', 'KnowledgeBaseController@customerLogout')->name('knowledgebase.customer_logout');
    Route::post('/{kb_locale}/hc/{mailbox_id}/auth/logout', 'KnowledgeBaseController@customerLogoutI18n')->name('knowledgebase.customer_logout_i18n');
    Route::post('/hc/{mailbox_id}/auth', 'KnowledgeBaseController@customerLoginProcess')->name('knowledgebase.customer_login_process');
    Route::post('/{kb_locale}/hc/{mailbox_id}/auth', 'KnowledgeBaseController@customerLoginProcessI18n')->name('knowledgebase.customer_login_process_i18n');
    Route::get('/hc/{mailbox_id}/auth/{customer_id}/{hash}/{timestamp}', 'KnowledgeBaseController@customerLoginFromEmail')->name('knowledgebase.customer_login_from_email');
    Route::get('/{kb_locale}/hc/{mailbox_id}/auth/{customer_id}/{hash}/{timestamp}', 'KnowledgeBaseController@customerLoginFromEmailI18n')->name('knowledgebase.customer_login_from_email_i18n');

    Route::get('/hc/{mailbox_id}', 'KnowledgeBaseController@frontend')->name('knowledgebase.frontend.home');
    Route::get('/{kb_locale}/hc/{mailbox_id}', 'KnowledgeBaseController@frontendI18n')->name('knowledgebase.frontend.home_i18n');
    Route::get('/hc/{mailbox_id}/search', 'KnowledgeBaseController@frontendSearch')->name('knowledgebase.frontend.search');
    Route::get('/{kb_locale}/hc/{mailbox_id}/search', 'KnowledgeBaseController@frontendSearchI18n')->name('knowledgebase.frontend.search_i18n');
    Route::get('/hc/{mailbox_id}/category/{category_id}', 'KnowledgeBaseController@frontendCategory')->name('knowledgebase.frontend.category');
    Route::get('/{kb_locale}/hc/{mailbox_id}/category/{category_id}', 'KnowledgeBaseController@frontendCategoryI18n')->name('knowledgebase.frontend.category_i18n');
    Route::get('/hc/{mailbox_id}/article/{article_id}', 'KnowledgeBaseController@frontendArticleBackward');
    // This must be the last
    Route::get('/hc/{mailbox_id}/{article_id}/{slug?}', 'KnowledgeBaseController@frontendArticle')->name('knowledgebase.frontend.article');
    Route::get('/{kb_locale}/hc/{mailbox_id}/{article_id}/{slug?}', 'KnowledgeBaseController@frontendArticleI18n')->name('knowledgebase.frontend.article_i18n');
    Route::get('/hc/{mailbox_id}/{article_id}', 'KnowledgeBaseController@frontendArticle')->name('knowledgebase.frontend.article_without_slug');
    Route::get('/{kb_locale}/hc/{mailbox_id}/{article_id}', 'KnowledgeBaseController@frontendArticleI18n')->name('knowledgebase.frontend.article_without_slug_i18n');
});

// Widget.
Route::group(['middleware' => [\App\Http\Middleware\EncryptCookies::class, \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, /*\Illuminate\Session\Middleware\StartSession::class, \Illuminate\View\Middleware\ShareErrorsFromSession::class,*/ /*\App\Http\Middleware\VerifyCsrfToken::class,*/ \Illuminate\Routing\Middleware\SubstituteBindings::class, \App\Http\Middleware\HttpsRedirect::class, \App\Http\Middleware\Localize::class], 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\KnowledgeBase\Http\Controllers'], function()
{
    Route::get('/knowledgebase/widget/form/{mailbox_id}', 'KnowledgeBaseWidgetController@widgetForm')->name('knowledgebase.widget_form');
    Route::post('/knowledgebase/widget/form/{mailbox_id}', 'KnowledgeBaseWidgetController@widgetFormProcess');
});
