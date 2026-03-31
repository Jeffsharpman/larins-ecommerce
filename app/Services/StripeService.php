<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Refund;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;

class StripeService
{
    protected StripeClient $client;

    public function __construct()
    {
        Stripe::setApiKey(config('stripe.secret_key'));
        $this->client = new StripeClient(config('stripe.secret_key'));
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

            $session = Session::create([
                'payment_method_types' => ['card', 'bank_transfer'],
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

            return [
                'success' => true,
                'status' => $session->payment_status,
                'customer_email' => $session->customer_email,
                'amount_total' => $session->amount_total / 100,
                'metadata' => $session->metadata,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe session verification failed', [
                'session_id' => $sessionId,
                'error' => $e->getMessage(),
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

    public function createRefund(string $paymentIntentId, ?int $amount = null): array
    {
        try {
            $params = [
                'payment_intent' => $paymentIntentId,
            ];

            if ($amount) {
                $params['amount'] = $amount * 100;
            }

            $refund = Refund::create($params);

            return [
                'success' => true,
                'refund_id' => $refund->id,
                'status' => $refund->status,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe refund failed', [
                'payment_intent_id' => $paymentIntentId,
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
        return config('stripe.public_key');
    }
}
