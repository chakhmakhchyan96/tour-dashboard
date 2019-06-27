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
        $this->app->make('AISTGlobal\TourDashboard\TourCategoryController');
        $this->app->make('AISTGlobal\TourDashboard\TourController');
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

        $this->publishes([
            __DIR__.'/views' => resource_path('views/vendor/tour-views'),
        ]);
    }
}
