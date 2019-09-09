<?php

namespace AISTGlobal\TourDashboard;

use Illuminate\Support\ServiceProvider;

class TourDashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('AISTGlobal\TourDashboard\TourFacilitiesController');
        $this->app->make('AISTGlobal\TourDashboard\CategoryController');
        $this->app->make('AISTGlobal\TourDashboard\TourController');
        $this->mergeConfigFrom(
            __DIR__.'/config/tour.php', 'tour'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        include __DIR__.'/routes.php';
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        $this->loadViewsFrom(__DIR__.'/views', 'tour-views');
        $this->loadViewsFrom(__DIR__.'/resources', 'tour-resources');

        $this->publishes([
            __DIR__.'/config/tour.php' => config_path('tour.php'),
        ]);
        $this->publishes([
            __DIR__.'/assets' => public_path('vendor/tour-dashboard'),
        ], 'public');
        $this->publishes([
            __DIR__.'/views/layouts' => base_path('resources/views/dashboard/layouts'),
        ], 'views');
    }

}
