<?php

namespace App\Http\Controllers\Payment;

use App\Helpers\CartManagement;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\StripeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StripeController extends Controller
{
    public function __construct(
        protected StripeService $stripe
    ) {}

    public function success(Request $request): RedirectResponse
    {
        $orderId = $request->query('order_id');
        $sessionId = $request->query('session_id');

        Log::info('=== STRIPE SUCCESS CALLBACK ===', [
            'full_url' => $request->fullUrl(),
            'order_id' => $orderId,
            'session_id' => $sessionId,
            'all_params' => $request->query(),
        ]);

        if (! $orderId) {
            Log::error('Stripe success: No order_id provided', $request->query());

            return redirect()->route('cancel')->with('error', 'Order not found');
        }

        $order = Order::find($orderId);

        if (! $order) {
            Log::error('Stripe success: Order not found', ['order_id' => $orderId]);

            return redirect()->route('cancel')->with('error', 'Order not found');
        }

        if (! $sessionId) {
            Log::warning('Stripe success: No session_id provided', [
                'order_id' => $orderId,
                'query_params' => $request->query(),
            ]);

            return redirect()->route('cancel')->with('error', 'Session not found');
        }

        $result = $this->stripe->verifySession($sessionId);

        Log::info('Stripe session verification result', [
            'session_id' => $sessionId,
            'result' => $result,
        ]);

        $paymentSuccess = false;

        if ($result['success']) {
            $status = strtolower($result['status'] ?? '');
            $sessionStatus = strtolower($result['session_status'] ?? '');

            Log::info('=== CHECKING PAYMENT STATUS ===', [
                'status' => $status,
                'session_status' => $sessionStatus,
            ]);

            // Accept multiple successful statuses
            if (in_array($status, ['paid', 'complete']) || in_array($sessionStatus, ['complete', 'paid'])) {
                $paymentSuccess = true;
            }
        }

        if ($paymentSuccess) {
            $order->update([
                'payment_status' => 'paid',
            ]);

            CartManagement::clearCartItems();

            Log::info('=== STRIPE PAYMENT SUCCESS ===', [
                'order_id' => $order->id,
                'session_id' => $sessionId,
                'amount' => $result['amount_total'] ?? 0,
            ]);

            return redirect()->route('success', [
                'order_id' => $order->id,
                'stripe_session' => $sessionId,
            ]);
        }

        Log::warning('=== STRIPE PAYMENT FAILED ===', [
            'order_id' => $order->id,
            'session_id' => $sessionId,
            'result' => $result,
        ]);

        return redirect()->route('cancel');
    }

    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $signature = $request->header('stripe-signature');

        $result = $this->stripe->constructWebhookEvent($payload, $signature);

        if (! $result['success']) {
            Log::error('Stripe webhook verification failed', [
                'message' => $result['message'],
            ]);

            return response()->json(['error' => 'Webhook verification failed'], 400);
        }

        $event = $result['event'];

        Log::info('Stripe webhook received', [
            'type' => $event->type,
            'id' => $event->id,
        ]);

        switch ($event->type) {
            case 'checkout.session.completed':
                $this->handleCheckoutSessionCompleted($event->data->object);
                break;

            case 'payment_intent.succeeded':
                $this->handlePaymentIntentSucceeded($event->data->object);
                break;

            case 'payment_intent.payment_failed':
                $this->handlePaymentIntentFailed($event->data->object);
                break;

            case 'charge.refunded':
                $this->handleChargeRefunded($event->data->object);
                break;

            default:
                Log::info('Unhandled Stripe webhook event', ['type' => $event->type]);
        }

        return response()->json(['status' => 'received'], 200);
    }

    protected function handleCheckoutSessionCompleted(object $session): void
    {
        $orderId = $session->metadata->order_id ?? null;

        if (! $orderId) {
            return;
        }

        $order = Order::find($orderId);

        if ($order && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
            ]);

            CartManagement::clearCartItems();

            Log::info('Stripe webhook: Order marked as paid via checkout.session.completed', [
                'order_id' => $order->id,
            ]);
        }
    }

    protected function handlePaymentIntentSucceeded(object $paymentIntent): void
    {
        $orderId = $paymentIntent->metadata->order_id ?? null;

        if (! $orderId) {
            return;
        }

        $order = Order::find($orderId);

        if ($order && $order->payment_status !== 'paid') {
            $order->update([
                'payment_status' => 'paid',
            ]);

            Log::info('Stripe webhook: Payment intent succeeded', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntent->id,
            ]);
        }
    }

    protected function handlePaymentIntentFailed(object $paymentIntent): void
    {
        $orderId = $paymentIntent->metadata->order_id ?? null;

        if (! $orderId) {
            return;
        }

        $order = Order::find($orderId);

        if ($order) {
            $order->update([
                'payment_status' => 'failed',
            ]);

            Log::info('Stripe webhook: Payment intent failed', [
                'order_id' => $order->id,
                'payment_intent_id' => $paymentIntent->id,
            ]);
        }
    }

    protected function handleChargeRefunded(object $charge): void
    {
        $orderId = $charge->payment_intent->metadata->order_id ?? null;

        if (! $orderId) {
            return;
        }

        $order = Order::find($orderId);

        if ($order) {
            $order->update([
                'status' => 'refunded',
            ]);

            Log::info('Stripe webhook: Charge refunded', [
                'order_id' => $order->id,
                'charge_id' => $charge->id,
            ]);
        }
    }
}
