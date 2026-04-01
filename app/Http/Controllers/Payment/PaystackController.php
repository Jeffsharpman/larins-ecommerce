<?php

namespace App\Http\Controllers\Payment;

use App\Helpers\CartManagement;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaystackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaystackController extends Controller
{
    public function __construct(
        protected PaystackService $paystack
    ) {}

    public function initialize(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'email' => 'required|email',
            'order_id' => 'required|exists:orders,id',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'phone' => 'nullable|string',
        ]);

        $user = auth()->user();
        $nameParts = $user?->nameParts() ?? ['first' => '', 'last' => ''];

        $result = $this->paystack->initializeTransaction([
            'email' => $request->email,
            'amount' => $request->amount,
            'order_id' => $request->order_id,
            'user_id' => $user->id,
            'first_name' => $request->first_name ?? $nameParts['first'],
            'last_name' => $request->last_name ?? $nameParts['last'],
            'phone' => $request->phone,
            'callback_url' => route('paystack.callback'),
            'currency' => 'NGN',
            'custom_fields' => [
                [
                    'display_name' => 'Order Number',
                    'variable_name' => 'order_number',
                    'value' => Order::find($request->order_id)?->order_number,
                ],
            ],
        ]);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'authorization_url' => $result['authorization_url'],
                'reference' => $result['reference'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'],
        ], 400);
    }

    public function callback(Request $request): RedirectResponse
    {
        $reference = $request->query('reference');

        if (! $reference) {
            Log::error('Paystack callback missing reference', ['request' => $request->all()]);

            return redirect()->route('cancel')->with('error', 'Payment reference not found');
        }

        $result = $this->paystack->verifyTransaction($reference);

        if (! $result['success']) {
            Log::error('Paystack verification failed', [
                'reference' => $reference,
                'result' => $result,
            ]);

            return redirect()->route('cancel')->with('error', $result['message']);
        }

        $orderId = $result['metadata']['order_id'] ?? null;

        if (! $orderId) {
            Log::error('Paystack callback missing order_id in metadata', [
                'reference' => $reference,
                'metadata' => $result['metadata'],
            ]);

            return redirect()->route('cancel')->with('error', 'Order not found');
        }

        $order = Order::find($orderId);

        if (! $order) {
            Log::error('Paystack callback order not found', ['order_id' => $orderId]);

            return redirect()->route('cancel')->with('error', 'Order not found');
        }

        if ($result['status'] === 'success') {
            $order->update([
                'payment_status' => 'paid',
            ]);

            CartManagement::clearCartItems();

            Log::info('Paystack payment successful', [
                'order_id' => $order->id,
                'reference' => $reference,
                'amount' => $result['amount'],
            ]);

            return redirect()->route('success', [
                'order_id' => $order->id,
                'paystack_reference' => $reference,
            ])->with('success', 'Payment successful');
        }

        $order->update([
            'payment_status' => 'failed',
        ]);

        Log::warning('Paystack payment failed', [
            'order_id' => $order->id,
            'reference' => $reference,
            'status' => $result['status'],
        ]);

        return redirect()->route('cancel')->with('error', 'Payment was not successful');
    }

    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->all();

        Log::info('Paystack webhook received', $payload);

        $signature = $request->header('x-paystack-signature');

        if (! $this->verifyWebhookSignature($payload, $signature)) {
            Log::error('Paystack webhook signature verification failed', [
                'signature' => $signature,
                'payload' => $payload,
            ]);

            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = $payload['event'] ?? null;

        switch ($event) {
            case 'charge.success':
                $this->handleSuccessfulCharge($payload['data']);
                break;

            case 'charge.failed':
                $this->handleFailedCharge($payload['data']);
                break;

            case 'refund.created':
                $this->handleRefundCreated($payload['data']);
                break;

            default:
                Log::info('Paystack unhandled webhook event', ['event' => $event]);
        }

        return response()->json(['status' => 'received'], 200);
    }

    protected function handleSuccessfulCharge(array $data): void
    {
        $orderId = $data['metadata']['order_id'] ?? null;

        if (! $orderId) {
            return;
        }

        $order = Order::find($orderId);

        if ($order && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
            ]);

            CartManagement::clearCartItems();

            Log::info('Paystack webhook: Payment marked as paid', [
                'order_id' => $order->id,
                'reference' => $data['reference'],
            ]);
        }
    }

    protected function handleFailedCharge(array $data): void
    {
        $orderId = $data['metadata']['order_id'] ?? null;

        if (! $orderId) {
            return;
        }

        $order = Order::find($orderId);

        if ($order) {
            $order->update([
                'payment_status' => 'failed',
            ]);

            Log::info('Paystack webhook: Payment marked as failed', [
                'order_id' => $order->id,
                'reference' => $data['reference'],
            ]);
        }
    }

    protected function handleRefundCreated(array $data): void
    {
        $orderId = $data['metadata']['order_id'] ?? null;

        if (! $orderId) {
            return;
        }

        $order = Order::find($orderId);

        if ($order) {
            $order->update([
                'status' => 'refunded',
            ]);

            Log::info('Paystack webhook: Order marked as refunded', [
                'order_id' => $order->id,
                'reference' => $data['reference'],
            ]);
        }
    }

    protected function verifyWebhookSignature(array $payload, ?string $signature): bool
    {
        if (! $signature || ! config('paystack.secret_key')) {
            return false;
        }

        $computedSignature = hash_hmac(
            'sha512',
            json_encode($payload),
            config('paystack.secret_key')
        );

        return hash_equals($computedSignature, $signature);
    }
}
