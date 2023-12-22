<?php

namespace App\Providers;

use App\Repositoreis\Cart\CartModelRepository;
use App\Repositoreis\Cart\CartRepository;
use App\Repositories\Cart\CartModelRepository as CartCartModelRepository;
use App\Repositories\Cart\CartRepository as CartCartRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CartCartRepository::class, function () {
            return new CartCartModelRepository;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
