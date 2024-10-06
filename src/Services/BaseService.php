<?php

namespace GoogleMerchant\Services;
class BaseService
{
    protected mixed $settings;

    public function __construct()
    {
        $this->settings = config("google-merchant"); // Load global settings from config
    }

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @return mixed
     */
    public function getSetting(string $key): mixed
    {
        return $this->settings[$key] ?? null; // Return setting value or null if not found
    }

}