@extends('layouts.layout')

@section('title', 'Payment Canceled')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-red-500">Payment Canceled</h1>
    <p>Your payment process was not completed. Please try again.</p>
    <a href="{{ route('home') }}" class="text-blue-500 hover:underline">Return to Home</a>
</div>
@endsection
