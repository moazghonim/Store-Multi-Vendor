<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        validator::extend('filter', function ($attribute, $value, $params) {
            return !in_array(strtolower($value), $params);
        }, 'This value is prohipted!');

        Paginator::useBootstrapFour();
    }
}
