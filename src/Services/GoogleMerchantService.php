<?php

namespace GoogleMerchant\Services;

use Google\Client;
use Google\Service\Script\Content;
use Illuminate\Http\JsonResponse;

class GoogleMerchantService extends BaseService
{
    protected Client $client;
    protected Content $contentService;

    public function __construct()
    {
        parent::__construct(); // Call the parent constructor to load settings
        $this->client = new Client();

        dd($this->client);
        $this->client->setApplicationName(config("google-merchant.application_name"));
        $this->client->setAuthConfig($this->getSetting(config("google-merchant.oauth_credentials_path"))); // Assuming you store client credentials in the config
        $this->client->setScopes([Content::CONTENT_SCOPE]); // Set the required scopes

        $this->contentService = new Content($this->client); // Initialize the Google Content API
    }

    /**
     * Add a product to Google Merchant.
     *
     * @param array $productData The product data to be added.
     * @return JsonResponse The added product or an error response.
     */
    public function addProduct(array $productData): JsonResponse
    {
        try {
            return $this->contentService->products->insert($productData);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}