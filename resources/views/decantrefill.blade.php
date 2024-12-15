@extends('layouts.layout') 
@section('title', 'Refill Decants') 
@section('content')

<style>
    .fade-in-bg {
        animation: fadeIn 2s ease-in-out forwards;
        opacity: 40;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% { 
            opacity: 1;
        }
    }
</style>

<!-- Main container -->
<div class="container mx-auto p-8 bg-purple">

    <!-- Refill Overview Section with Cream and Peach Tones -->
    <div class="bg-gradient-to-r from-blue-300 via-peach-400 to-cream text-black p-8 rounded-xl shadow-xl relative overflow-hidden bg-cover bg-center bg-no-repeat parallax fade-in-bg" style="background-image: url('refillwall.jpeg');">

        <div class="absolute inset-0 bg-black opacity-30"></div>
        <div class="relative z-10">
        <h2 class="text-4xl font-extrabold leading-tight mb-6 animate__animated animate__fadeIn animate__delay-1s animate__duration-3s">Refill Your Perfume Decants</h2>
        <p class="text-lg mb-8 animate__animated animate__fadeIn animate__delay-2s animate__duration-3s">
            Conveniently refill your favorite premium decants with our seamless refill service. Choose your preferred scents from our extensive selection and keep your signature style alive. Each refill is affordably priced and delivered directly to your doorstep.
        </p>
        
    </div>
    </div>

    

<!-- Refill Details Form Section with Enhanced Design -->
<!-- Refill Details Form Section with Enhanced Design -->
<div class="mt-16 p-8 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl shadow-xl hover:shadow-2xl transition-all ease-in-out duration-500 max-w-lg mx-auto">
    <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">Refill Request Details</h2>
    
    <!-- Flash success message -->
    @if(session('success'))
        <div id="success-message" class="fixed top-0 right-0 m-4 p-4 bg-green-500 text-white rounded-lg shadow-lg">
            <p>{{ session('success') }}</p>
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('success-message').style.display = 'none';
            }, 7000); // Hide the message after 5 seconds
        </script>
    @endif
    
    <form action="{{ route('refilling_request.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="flex flex-col">
            <label for="full_name" class="text-lg font-medium text-gray-700">Full Name:</label>
            <input type="text" id="full_name" name="full_name" placeholder="Enter your full name" required class="mt-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
        </div>
    
        <div class="flex flex-col">
            <label for="address" class="text-lg font-medium text-gray-700">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter your address" required class="mt-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
        </div>
    
        <div class="flex flex-col">
            <label for="phone_number" class="text-lg font-medium text-gray-700">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" placeholder="Enter your phone number" required class="mt-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
        </div>
    
        <div class="flex flex-col">
            <label for="decant_name" class="text-lg font-medium text-gray-700">Decant:</label>
            <select id="decant_name" name="decant_name" required class="mt-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @foreach ($decants as $decant)
                    <option value="{{ $decant['name'] }}" data-price="{{ $decant['price'] }}">
                        {{ $decant['name'] }} - Rs.{{ $decant['price'] }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <div class="flex flex-col">
            <label for="size" class="text-lg font-medium text-gray-700">Size:</label>
            <select id="size" name="size" required class="mt-2 p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:outline-none">
                <option value="5ml">5ml</option>
                <option value="10ml">10ml</option>
            </select>
        </div>
    
        <input type="hidden" id="price" name="price">
    
        <div class="flex justify-center mt-6">
            <button type="submit" class="w-full bg-purple-600 text-white py-3 rounded-lg shadow-md hover:bg-purple-700 transition duration-300 ease-in-out">
                Submit Request
            </button>
        </div>
    </form>
</div>


    
    <script>
        const decantSelect = document.querySelector('#decant_name');
        const priceInput = document.querySelector('#price');
    
        decantSelect.addEventListener('change', function() {
            const selectedOption = decantSelect.options[decantSelect.selectedIndex];
            priceInput.value = selectedOption.dataset.price;
        });
    
        // Initialize price on page load
        if (decantSelect.options.length > 0) {
            priceInput.value = decantSelect.options[0].dataset.price;
        }
    </script>

@endsection
