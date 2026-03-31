<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected string $secretKey;

    protected string $publicKey;

    protected string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('paystack.secret_key');
        $this->publicKey = config('paystack.public_key');
        $this->baseUrl = 'https://api.paystack.co';
    }

    public function initializeTransaction(array $data): array
    {
        $reference = $this->generateReference();

        $payload = [
            'email' => $data['email'],
            'amount' => (int) ($data['amount'] * 100),
            'currency' => $data['currency'] ?? 'NGN',
            'reference' => $reference,
            'callback_url' => $data['callback_url'],
            'metadata' => [
                'order_id' => $data['order_id'] ?? null,
                'user_id' => $data['user_id'] ?? null,
                'custom_fields' => $data['custom_fields'] ?? [],
            ],
        ];

        if (isset($data['first_name']) && isset($data['last_name'])) {
            $payload['first_name'] = $data['first_name'];
            $payload['last_name'] = $data['last_name'];
        }

        if (isset($data['phone'])) {
            $payload['phone'] = $data['phone'];
        }

        try {
            $response = Http::withToken($this->secretKey)
                ->post("{$this->baseUrl}/transaction.initialize", $payload);

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? false)) {
                return [
                    'success' => true,
                    'reference' => $reference,
                    'authorization_url' => $result['data']['authorization_url'],
                    'access_code' => $result['data']['access_code'],
                ];
            }

            Log::error('Paystack initialization failed', [
                'response' => $result,
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Failed to initialize transaction',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack initialization error', [
                'error' => $e->getMessage(),
                'payload' => $payload,
            ]);

            return [
                'success' => false,
                'message' => 'Payment service temporarily unavailable',
            ];
        }
    }

    public function verifyTransaction(string $reference): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->get("{$this->baseUrl}/transaction/verify/{$reference}");

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? false)) {
                $data = $result['data'];

                return [
                    'success' => true,
                    'status' => $data['status'],
                    'reference' => $data['reference'],
                    'amount' => $data['amount'] / 100,
                    'currency' => $data['currency'],
                    'customer_email' => $data['customer']['email'],
                    'customer_phone' => $data['customer']['phone'] ?? null,
                    'authorization' => $data['authorization'],
                    'metadata' => $data['metadata'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Transaction verification failed',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack verification error', [
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Unable to verify transaction',
            ];
        }
    }

    public function chargeAuthorization(array $data): array
    {
        $payload = [
            'email' => $data['email'],
            'amount' => (int) ($data['amount'] * 100),
            'authorization_code' => $data['authorization_code'],
            'reference' => $this->generateReference(),
            'currency' => $data['currency'] ?? 'NGN',
        ];

        try {
            $response = Http::withToken($this->secretKey)
                ->post("{$this->baseUrl}/transaction/charge_authorization", $payload);

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? false)) {
                return [
                    'success' => true,
                    'status' => $result['data']['status'],
                    'reference' => $result['data']['reference'],
                ];
            }

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Charge failed',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack charge error', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Charge failed',
            ];
        }
    }

    public function refund(string $transactionReference): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->post("{$this->baseUrl}/refund", [
                    'transaction' => $transactionReference,
                ]);

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? false)) {
                return [
                    'success' => true,
                    'refund_reference' => $result['data']['reference'],
                    'amount' => $result['data']['amount'] / 100,
                ];
            }

            return [
                'success' => false,
                'message' => $result['message'] ?? 'Refund failed',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack refund error', [
                'reference' => $transactionReference,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Refund failed',
            ];
        }
    }

    public function getTransactionTimeline(string $reference): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->get("{$this->baseUrl}/timeline/{$reference}");

            $result = $response->json();

            if ($response->successful()) {
                return [
                    'success' => true,
                    'timeline' => $result['data'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => 'Unable to fetch timeline',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    protected function generateReference(): string
    {
        return 'PSK_'.time().'_'.str()->random(8);
    }

    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}
