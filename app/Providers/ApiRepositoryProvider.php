<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiRepositoryProvider extends ServiceProvider
{

    protected $defer = false;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Contract\UserInterface','App\Repositories\Eloquent\UserRepository');
        $this->app->bind('App\Repositories\Contract\ShopInterface','App\Repositories\Eloquent\ShopRepository');
        $this->app->bind('App\Repositories\Contract\ProductInterface','App\Repositories\Eloquent\ProductRepository');
    }

    /**
     * provides the application services.
     *
     * @return [Array]
     */
    public function provides()
    {

    }
}
