<?php

namespace GoogleMerchant\Services;

use Exception;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Auth\Middleware\AuthTokenMiddleware;
use \Google\Client;
use \Google\Service\Script\Content;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class GoogleMerchantService extends BaseService
{
    protected string $merchantId;

    /**
     * The OAuth token credentials.
     *
     * @var ServiceAccountCredentials
     */
    protected ServiceAccountCredentials $credentials;

    public function __construct()
    {
        parent::__construct(); // Call the parent constructor to load settings

        // Load the service account credentials from the JSON file
        $this->credentials = new ServiceAccountCredentials(
            "https://www.googleapis.com/auth/content",
            public_path(config("google-merchant.oauth_credentials_path"))  // Path to your service account file
        );

        // Get Merchant ID from config
        $this->merchantId = config("google-merchant.merchant_id");
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
            // Send a POST request to add a product
            $response = Http::withToken($this->getAccessToken()) // Get OAuth token
            ->withOptions([
                "verify" => false, // Disable SSL certificate verification
            ])->post("https://content.googleapis.com/content/v2.1/{$this->merchantId}/products", [
                    "offerId" => $productData["offerId"],
                    "title" => $productData["title"],
                    "description" => $productData["description"],
                    "link" => $productData["link"],
                    "imageLink" => $productData["imageLink"],
                    "contentLanguage" => $productData["contentLanguage"],
                    "targetCountry" => $productData["targetCountry"],
                    "channel" => $productData["channel"],
                    "availability" => $productData["availability"],
                    "price" => [
                        "value" => $productData["price"]["value"],
                        "currency" => $productData["price"]["currency"],
                    ],
                    "shipping" => [
                        [
                            "country" => $productData["shipping"][0]["country"],
                            "price" => [
                                "value" => $productData["shipping"][0]["price"]["value"],
                                "currency" => $productData["shipping"][0]["price"]["currency"],
                            ],
                        ],
                    ],
                    "condition" => $productData["condition"],
                    "gtin" => $productData["gtin"],
                    "brand" => $productData["brand"],
                    "mpn" => $productData["mpn"],
                ]
            );

            // Return the response in JSON format
            return $response->json();
        } catch (\Exception $e) {
            // Handle exceptions and return error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update a product in Google Merchant.
     *
     * @param string $productId The ID of the product to be updated.
     * @param array $productData The product data to be updated.
     * @return JsonResponse The updated product or an error response.
     */
    public function updateProduct(string $productId, array $productData): JsonResponse
    {
        try {
            // Send a PUT request to update the product
            $response = Http::withToken($this->getAccessToken()) // Get OAuth token
            ->withOptions([
                "verify" => false, // Disable SSL certificate verification
            ])->put("https://content.googleapis.com/content/v2.1/{$this->merchantId}/products/{$productId}", [
                    "offerId" => $productData["offerId"],
                    "title" => $productData["title"],
                    "description" => $productData["description"],
                    "link" => $productData["link"],
                    "imageLink" => $productData["imageLink"],
                    "contentLanguage" => $productData["contentLanguage"],
                    "targetCountry" => $productData["targetCountry"],
                    "channel" => $productData["channel"],
                    "availability" => $productData["availability"],
                    "price" => [
                        "value" => $productData["price"]["value"],
                        "currency" => $productData["price"]["currency"],
                    ],
                    "shipping" => [
                        [
                            "country" => $productData["shipping"][0]["country"],
                            "price" => [
                                "value" => $productData["shipping"][0]["price"]["value"],
                                "currency" => $productData["shipping"][0]["price"]["currency"],
                            ],
                        ],
                    ],
                    "condition" => $productData["condition"],
                    "gtin" => $productData["gtin"],
                    "brand" => $productData["brand"],
                    "mpn" => $productData["mpn"],
                ]
            );

            // Return the response in JSON format
            return $response->json();
        } catch (\Exception $e) {
            // Handle exceptions and return error message
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get OAuth access token.
     *
     * @return string The access token.
     * @throws Exception If unable to fetch access token.
     */
    protected function getAccessToken(): string
    {
        // Create a Guzzle HTTP client with OAuth token middleware
        $middleware = new AuthTokenMiddleware($this->credentials);
        $stack = HandlerStack::create();
        $stack->push($middleware);

        // Create a Guzzle client with the handler stack and disable SSL verification for testing
        $guzzleClient = new GuzzleClient(['handler' => $stack, 'verify' => false]);

        // Build the callable HTTP handler for token fetching
        $httpHandler = HttpHandlerFactory::build($guzzleClient);

        // Fetch the OAuth access token
        $token = $this->credentials->fetchAuthToken($httpHandler);

        // Ensure the token is valid
        if (!isset($token['access_token'])) {
            throw new Exception('Error fetching access token: ' . ($token['error_description'] ?? 'Unknown error'));
        }

        return $token['access_token'];
    }
}
