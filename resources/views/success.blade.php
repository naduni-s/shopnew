@extends('layouts.layout')

@section('title', 'Payment Success')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold text-green-500">Payment Successful!</h1>
    <p>Thank you for your payment. Your transaction was successfully processed.</p>
    <a href="{{ route('home') }}" class="text-blue-500 hover:underline">Return to Home</a>
</div>
@endsection
