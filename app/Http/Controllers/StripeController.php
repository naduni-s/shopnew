<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefillRequest;
use App\Models\Payment;  // <-- Make sure this line is added

class StripeController extends Controller
{
    public function stripe(Request $request)
    {
        // Convert price to the smallest currency unit (e.g., cents for Stripe)
        $amount = $request->price * 100; // Ensure price is numeric and multiplied to cents
    
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
        $response = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'lkr', // Set correct currency code
                    'product_data' => [
                        'name' => $request->decant_name,
                        'description' => 'Size: ' . $request->size,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'request_id' => $request->id,
                'customer_name' => $request->full_name,
                'product_name' => $request->decant_name,
            ],
            'mode' => 'payment',
            'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('cancel'),
        ]);
        return redirect($response->url);
    }

    public function success(Request $request)
    {
        // Retrieve the session_id from the URL
        $sessionId = $request->query('session_id');

        // Initialize Stripe client
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

        // Retrieve session details
        $session = $stripe->checkout->sessions->retrieve($sessionId);

        // Extract metadata
        $customerName = $session->metadata['customer_name'];
        $productName = $session->metadata['product_name'];

        // Save payment details in the database
        $payment = new Payment();  // Use the Payment model
        $payment->session_id = $session->id;
        $payment->customer_name = $customerName;
        $payment->product_name = $productName;
        $payment->customer_email = $session->customer_email; 
        $payment->amount = $session->amount_total / 100; // Convert from cents to the actual amount
        $payment->currency = $session->currency;
        $payment->payment_status = $session->payment_status;
        $payment->save();

        // Update the related refill request (if applicable)
        $refillRequest = RefillRequest::find($session->metadata['request_id']);
        if ($refillRequest) {
            $refillRequest->status = 'Paid';
            $refillRequest->save();
        }

        // Redirect to success page
        return view('success', ['session' => $session]);
    }

    public function cancel()
    {
        return view('cancel');
    }
}
