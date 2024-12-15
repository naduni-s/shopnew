@extends('layouts.layout')

@section('title', 'Request Summary')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">My Requests</h1>

    @if($requests->isEmpty())
        <p class="text-gray-500">No requests found.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($requests as $request)
                <div class="border p-4 rounded-lg shadow-lg">
                    <h2 class="text-lg font-medium">{{ $request->decant_name }}</h2>
                    <p class="text-sm text-gray-500">Size: {{ $request->size }}</p>
                    <p class="text-sm text-gray-500">Price: Rs.{{ number_format($request->price, 2) }}</p>
                    <p class="text-sm text-gray-500">Status:
                        @if($request->status === 'Pending')
                            <span class="text-yellow-500 font-bold">Pending</span>
                        @elseif($request->status === 'Approved')
                            <span class="text-green-500 font-bold">Approved</span>
                        @elseif($request->status === 'Paid')
                            <span class="text-blue-500 font-bold">Paid</span>
                        @elseif($request->status === 'Rejected')
                            <span class="text-red-500 font-bold">Rejected</span>
                        @endif
                    </p>

                    @if($request->status === 'Approved')
                    <form action="{{ route('stripe') }}" method="POST">
                        @csrf
                        <input type="hidden" name="decant_name" value="{{ $request->decant_name }}">
                        <input type="hidden" name="size" value="{{ $request->size }}">
                        <input type="hidden" name="price" value="{{ $request->price }}">
                        <input type="hidden" name="full_name" value="{{ $request->full_name }}">

                        <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-lg">
                            Pay Now
                        </button>
                    </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
