<?php

namespace App\Services;

use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeService
{
    protected StripeClient $client;

    public function __construct()
    {
        $settings = app(GeneralSettings::class);

        $secretKey = $settings->stripe_secret_key ?? config('stripe.secret_key');

        Stripe::setApiKey($secretKey);
        $this->client = new StripeClient($secretKey);
    }

    public function createCheckoutSession(array $data): array
    {
        try {
            $lineItems = [];
            foreach ($data['items'] as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'ngn',
                        'unit_amount' => (int) ($item['unit_amount'] * 100),
                        'product_data' => [
                            'name' => $item['name'],
                            'description' => $item['description'] ?? null,
                        ],
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            if (! empty($data['tax_amount']) && $data['tax_amount'] > 0) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'ngn',
                        'unit_amount' => (int) ($data['tax_amount'] * 100),
                        'product_data' => [
                            'name' => 'Tax',
                            'description' => 'Taxes and duties',
                        ],
                    ],
                    'quantity' => 1,
                ];
            }

            $session = Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => $data['email'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => $data['success_url'],
                'cancel_url' => $data['cancel_url'],
                'metadata' => [
                    'order_id' => $data['order_id'],
                    'user_id' => $data['user_id'],
                ],
                'shipping_options' => [
                    [
                        'shipping_rate_data' => [
                            'type' => 'fixed_amount',
                            'fixed_amount' => [
                                'amount' => (int) ($data['shipping_amount'] * 100),
                                'currency' => 'ngn',
                            ],
                            'display_name' => $data['shipping_method'] ?? 'Standard Shipping',
                        ],
                    ],
                ],
            ]);

            return [
                'success' => true,
                'url' => $session->url,
                'session_id' => $session->id,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe checkout session creation failed', [
                'error' => $e->getMessage(),
                'data' => $data,
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function verifySession(string $sessionId): array
    {
        try {
            $session = Session::retrieve($sessionId);

            $logData = [
                'session_id' => $sessionId,
                'payment_status' => $session->payment_status,
                'status' => $session->status,
                'payment_intent' => $session->payment_intent,
                'customer_email' => $session->customer_email,
                'amount_total' => $session->amount_total,
                'currency' => $session->currency,
            ];

            Log::info('=== STRIPE SESSION FULL DATA ===', $logData);

            return [
                'success' => true,
                'status' => $session->payment_status,
                'session_status' => $session->status,
                'customer_email' => $session->customer_email,
                'amount_total' => $session->amount_total / 100,
                'metadata' => $session->metadata,
            ];
        } catch (\Exception $e) {
            Log::error('=== STRIPE VERIFICATION ERROR ===', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function constructWebhookEvent(string $payload, string $signature): array
    {
        try {
            $webhookSecret = config('stripe.webhook_secret');

            if (! $webhookSecret) {
                return [
                    'success' => false,
                    'message' => 'Webhook secret not configured',
                ];
            }

            $event = Webhook::constructEvent(
                $payload,
                $signature,
                $webhookSecret
            );

            return [
                'success' => true,
                'event' => $event,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe webhook verification failed', [
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function getPublicKey(): string
    {
        $settings = app(GeneralSettings::class);

        return $settings->stripe_public_key ?? config('stripe.public_key');
    }
}
