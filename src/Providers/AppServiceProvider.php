<?php

namespace GoogleMerchant\Providers;
// Use the correct namespace

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws BindingResolutionException
     */
    public function boot()
    {
        // Load migrations and factories from the package
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->app->make(Factory::class)->load(__DIR__ . '/../database/factories');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Register the Google Merchant service provider
        $this->app->register(GoogleMerchantServiceProvider::class);
        // Register any other service providers here as needed
    }
}
