<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function showSubscriptionPage()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please log in to start your subscription.');
        }

        return view('subscription'); // Adjust the view name as necessary
    }

    public function checkSubscription()
    {
        if (!Auth::check()) {
            // Redirect to login page with a message
            return redirect()->route('login')->with('message', 'Please log in to start your subscription.');
        }

        // If the user is logged in, redirect to the subscription form
        return redirect()->route('subscription');
    }

       //Route to subscription in admin page
       public function Subscription()
       {
           if (!Auth::check()) {
               return redirect()->route('login')->with('message', 'Please log in to access the subscription page.');
           }
       
           $userName = Auth::user()->name;
       
           return view('sub', compact('userName'));
       }

       

       


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'gender' => 'required|string',
            'perfumes' => 'required|array|min:1',
            'perfumes.*' => 'string|nullable',
            'notes' => 'nullable|string',
            'agreed_to_terms' => 'accepted',
        ]);

        $perfumes = implode(',', array_filter($request->perfumes));

        Subscription::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'perfumes' => $perfumes,
            'notes' => $request->notes,
            'agreed_to_terms' => true,
        ]);

        return redirect()->back()->with('success', 'SCENTSCRIBE SUCCESSFULLY!!');
    }

    public function showSubscriptions()
    {
        $subscriptions = Subscription::all();

        return view('admin.subscription', compact('subscriptions'));
    }

    
}
