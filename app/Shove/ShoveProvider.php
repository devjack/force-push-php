<?php

namespace App\Shove;

use Illuminate\Support\ServiceProvider;
use App\Shove\Push;

class ShoveProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('shove', function () {
            return new Push();
        });
        //$this->app->alias('shove', Push::class);
    }


    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return ['shove'];
    }
}