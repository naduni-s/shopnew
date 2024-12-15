<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Decant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class DecantController extends Controller

{
    public function index()
    {
        $decants = Decant::all();
        return view('decantrefill', compact('decants'));
//     return view('decantrefill');
    }

}
