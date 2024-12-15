<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefillRequest;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class RefillRequestController extends Controller
{
    // Display the refill request form
    public function create()
    {
        $decants = [
            ['name' => 'Chanel No. 5', 'price' => 50.00],
            ['name' => 'Dior Sauvage', 'price' => 55.00],
            ['name' => 'Gucci Bloom', 'price' => 45.00],
            ['name' => 'Versace Eros', 'price' => 60.00],
            ['name' => 'Tom Ford Oud Wood', 'price' => 75.00],
            ['name' => 'YSL Black Opium', 'price' => 70.00],
            ['name' => 'Jo Malone Lime Basil', 'price' => 65.00],
            ['name' => 'Prada Luna Rossa', 'price' => 55.00],
            ['name' => 'Creed Aventus', 'price' => 85.00],
            ['name' => 'Armani Code', 'price' => 50.00],
        ];
        return view('decantrefill', compact('decants'));
    }

    // Store the refill request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'decant_name' => 'required|string',
            'price' => 'required|numeric',
            'size' => 'required|in:5ml,10ml',
        ]);

        // Create the refill request
        RefillRequest::create($validated);

        // Redirect with success message
        return redirect()->route('refilling_request.create')->with('success', 'Request submitted successfully!');
    }

    // View the admin refilling requests and payment details
    public function adminView()
    {
        // Retrieve all refill requests and payments
        $requests = RefillRequest::all();
        $payments = Payment::all();

        // Pass both requests and payments to the view
        return view('admin.refilling', compact('requests', 'payments'));
    }

    // Update the status of a refill request
    public function update(Request $request, RefillRequest $refillRequest)
    {
        // Validate the status input
        $validated = $request->validate([
            'status' => 'required|string|in:Pending,Approved,Rejected,Paid',  // Validate that only valid statuses are accepted
        ]);

        // Update the status of the refill request
        $refillRequest->status = $validated['status'];
        $refillRequest->save();

        // Redirect with success message
        return redirect()->route('admin.refilling')->with('success', 'Request status updated successfully!');
    }

    // Show payment details (separate from refill requests)
    public function showPayments()
    {
        // Retrieve all payment records from the database
        $payments = Payment::all();

        // Return the view with only payments (if you need a separate payments view)
        return view('admin.refilling', compact('payments'));
    }
}
