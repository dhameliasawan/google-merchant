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
    public function boot(): void
    {
        // Load migrations and factories from the package
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->app->make(Factory::class)->load(__DIR__ . '/../database/factories');
        $this->mergeConfigFrom(__DIR__ . "/../config/google-merchant.php", "google-merchant");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the Google Merchant service provider
        $this->app->register(GoogleMerchantServiceProvider::class);
        // Register any other service providers here as needed
    }
}
