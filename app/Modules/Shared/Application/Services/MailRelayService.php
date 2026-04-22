<?php

namespace App\Modules\Shared\Application\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailRelayService
{
    protected ?string $apiUrl;
    protected ?string $apiKey;
    protected array $defaultGroups;

    public function __construct()
    {
        $this->apiUrl = config('services.mailrelay.api_url');
        $this->apiKey = config('services.mailrelay.api_key');
        $this->defaultGroups = explode(',', config('services.mailrelay.default_groups', '1'));

        // Validate configuration
        if (empty($this->apiUrl) || empty($this->apiKey)) {
            \Log::warning('MailRelay service not configured. Please set MAILRELAY_API_URL and MAILRELAY_API_KEY in .env file');
        }
    }

    public function isConfigured(): bool
    {
        return !empty($this->apiUrl) && !empty($this->apiKey);
    }

    public function subscribeContact(string $email, string $name, array $additionalData = []): bool
    {
        // Check if service is configured
        if (!$this->isConfigured()) {
            Log::warning('MailRelay subscription attempted but service is not configured', [
                'email' => $email
            ]);
            return false;
        }

        try {
            // MailRelay API v3 uses JSON and X-AUTH-TOKEN header
            $payload = [
                'email' => $email,
                'name' => $name,
                'status' => 'active',
                'group_ids' => array_map('intval', $this->defaultGroups),
            ];

            // Add additional custom fields if provided
            if (!empty($additionalData)) {
                $payload['custom_fields'] = $additionalData;
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'X-AUTH-TOKEN' => $this->apiKey,
                ])
                ->post($this->apiUrl . '/subscribers', $payload);

            if ($response->successful()) {
                Log::info('MailRelay subscription successful', [
                    'email' => $email,
                    'response' => $response->json()
                ]);
                return true;
            }

            // Handle duplicate subscriber (422 error)
            if ($response->status() === 422) {
                $responseData = $response->json();

                // Check if it's a "Subscriber already exists" error
                if (
                    isset($responseData['errors']['email']) &&
                    in_array('Subscriber already exists.', $responseData['errors']['email'])
                ) {

                    Log::info('MailRelay subscriber already exists (treating as success)', [
                        'email' => $email
                    ]);

                    // Return true because the subscriber is already in the system
                    return true;
                }
            }

            Log::warning('MailRelay API request failed', [
                'email' => $email,
                'status' => $response->status(),
                'response' => $response->json() ?? $response->body()
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error('MailRelay subscription error', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }
}
