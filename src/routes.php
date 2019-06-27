<?php

Route::get('test', function(){
    echo 'Hello from the test package!';
});
//
//Route::group(['middleware' => ['web']], function () {
//
//    Route::resource('cat', '\AISTGlobal\TourDashboard\TourCategoryController');
//
//});

Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale() .'/dashboard',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web']
    ],

    function () {

//        Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);
        Route::resource('tours', '\AISTGlobal\TourDashboard\TourController');
        Route::resource('categories', '\AISTGlobal\TourDashboard\TourCategoryController');
//        Route::get('/translations', ['as' => 'translation_manager', 'uses' => '\Barryvdh\TranslationManager\Controller@getIndex']);
//        Route::get('/translations/view/{group?}', ['as' => 'translation_group', 'uses' => '\Barryvdh\TranslationManager\Controller@getView']);
    });