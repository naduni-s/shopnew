<?php  

namespace App\Http\Controllers;
use App\Models\RefillDetail;

use Illuminate\Http\Request;

class RefillDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'address' => 'required|string',
            'decants' => 'required|array',
            'agreed_to_terms' => 'accepted',
        ]);

        // Save the data
        RefillDetail::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'decants' => implode(', ', $request->decants), // Convert array to string
            'notes' => $request->notes,
        ]);

        return redirect()->back()->with('success', 'Refill details submitted successfully.');
    }

    public function refill()
    {
        $refillDetails = RefillDetail::all();
        return view('admin.refilling', compact('refillDetails'));
    }



}