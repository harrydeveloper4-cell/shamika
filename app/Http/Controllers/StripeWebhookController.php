<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('stripe-signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                // Fulfill the purchase...
                $this->handleCheckoutSessionCompleted($session);
                break;
            // ... handle other event types
            default:
                // Log unknown event type
                // Log::info('Received unknown Stripe event type: ' . $event->type);
                break;
        }

        return response()->json(['status' => 'success'], 200);
    }

    protected function handleCheckoutSessionCompleted($session)
    {
        $bookingId = $session->metadata->booking_id;
        $renterId = $session->metadata->renter_id;
        $amountTotal = $session->amount_total; // amount_total is in cents

        $booking = Booking::find($bookingId);

        if ($booking && $booking->renter_id == $renterId) {
            // Update booking status
            $booking->update(['status' => 'completed']);

            // Create a payment record
            Payment::create([
                'renter_id' => $renterId,
                'booking_id' => $bookingId,
                'amount' => $amountTotal / 100, // Convert back to dollars/currency unit
                'currency' => strtoupper($session->currency),
                'payment_method' => 'stripe', // Or session->payment_method_types[0] if available
                'transaction_id' => $session->id,
                'status' => 'succeeded', // Stripe checkout session completed implies success
                'type' => 'booking_payment',
                'paid_at' => now(),
            ]);
        }
    }
}