<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RefillRequest;

class RequestController extends Controller
{
    public function index()
    {
        // Fetch all requests from the database
        $requests = RefillRequest::all();

        return view('requests', compact('requests'));
    }
}
