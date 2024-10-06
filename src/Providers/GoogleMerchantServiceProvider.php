<?php

namespace GoogleMerchant\Providers;

use Illuminate\Support\ServiceProvider;

class GoogleMerchantServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Load configuration file
        $this->mergeConfigFrom(__DIR__ . "/../config/google-merchant.php", "google-merchant");
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__ . "/../config/google-merchant.php" => config_path("google-merchant.php"),
        ], 'config');
    }
}