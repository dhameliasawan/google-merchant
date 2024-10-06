<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Merchant Configuration
    |--------------------------------------------------------------------------
    |
    | This array contains the configuration for Google Merchant including
    | the Merchant ID, API key, and OAuth credentials path.
    |
    */
    "merchant_id" => env("GOOGLE_MERCHANT_ID"),
    "api_key" => env("GOOGLE_MERCHANT_API_KEY"),
    "oauth_credentials_path" => env("GOOGLE_OAUTH_CREDENTIALS_PATH"),

    /*
    |--------------------------------------------------------------------------
    | Google Merchant Currency
    |--------------------------------------------------------------------------
    |
    | This value defines the currency in which you want to process product listings.
    | Google Merchant supports multiple currencies such as USD, EUR, etc.
    |
    */
    "currency" => "INR",

    /*
    |--------------------------------------------------------------------------
    | Google Merchant Application Name
    |--------------------------------------------------------------------------
    |
    | This value sets the name of your application for Google Merchant API.
    |
    */
    "application_name" => env("GOOGLE_APPLICATION_NAME", "Your Application Name"),

    /*
    |--------------------------------------------------------------------------
    | Google Merchant Product Feed Settings
    |--------------------------------------------------------------------------
    |
    | This array contains settings for your product feed, including title,
    | description, and default locale.
    |
    */
    "product_feed" => [
        "title" => env("GOOGLE_FEED_TITLE", "Your Product Feed Title"),
        "description" => env("GOOGLE_FEED_DESCRIPTION", "Your Product Feed Description"),
        "language" => env("GOOGLE_FEED_LANGUAGE", "en_US"),
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Merchant API Version
    |--------------------------------------------------------------------------
    |
    | This value defines the version of the Google Merchant API you want to use.
    |
    */
    "api_version" => env("GOOGLE_API_VERSION", "v2.1"),
];
