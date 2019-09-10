<?php
//
Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale() .'/dashboard',
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'web']
    ],

//    php artisan vendor:publish --tag=public --provider="AISTGlobal\TourDashboard\TourDashboardServiceProvider" --force

    function () {

        Route::resource('tours', '\AISTGlobal\TourDashboard\TourController')->except([
            'show'
        ]);
        Route::resource('facilities', '\AISTGlobal\TourDashboard\TourFacilitiesController')->except([
            'show'
        ]);

        Route::resource('categories', '\AISTGlobal\TourDashboard\CategoryController')->except([
            'create', 'index', 'show'
        ]);
        Route::get('/categories/create/{type}', '\AISTGlobal\TourDashboard\CategoryController@create');
        Route::get('/categories/{type}', '\AISTGlobal\TourDashboard\CategoryController@index');

    });

Route::group(
    [
        'prefix' => 'dashboard',
    ],

    function () {

        Route::post('tour-plan','\AISTGlobal\TourDashboard\TourController@storeTourPlan');
        Route::post('tour-facilities','\AISTGlobal\TourDashboard\TourController@storeFacilities');
        Route::post('tour-plan-day','\AISTGlobal\TourDashboard\TourController@storeTourPlanDay');
        Route::post('tour-location','\AISTGlobal\TourDashboard\TourController@storeTourLocation');
        Route::post('tour-gallery','\AISTGlobal\TourDashboard\TourController@storeTourGallery');
        Route::post('tour-meta','\AISTGlobal\TourDashboard\TourController@storeTourMeta');
        Route::post('tour-hotels','\AISTGlobal\TourDashboard\TourController@storeHotels');
        Route::delete('tour-included/{id}','\AISTGlobal\TourDashboard\TourController@deleteTourIncluded');
        Route::delete('tour-plan-day/{id}','\AISTGlobal\TourDashboard\TourController@deleteTourPlanDay');
    });