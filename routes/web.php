<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MenController;
use App\Http\Controllers\WomenController;
use App\Http\Controllers\UniController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StoreLocatorController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeProductController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RefillDetailController;
use App\Http\Controllers\RefillRequestController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DecantController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/* Public Routes */
Route::get('/', function () {
    return view('home');
});

Route::get('/mens', [MenController::class, 'index'])->name('formen');
Route::get('/women', [WomenController::class, 'index'])->name('forwomen');
Route::get('/unisex', [UniController::class, 'index'])->name('unisex');
Route::get('/decantrefill', [DecantController::class, 'index'])->name('decantrefill');
Route::get('/requests',[RequestController::class, 'index'])->name('requests');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


/* Authenticated Routes */
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Dashboard (Protected by 'auth' middleware)
    Route::middleware(['auth'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });
    

    Route::post('/admin/store-product', [AdminController::class, 'storeProduct'])->name('admin.storeProduct');


    // Logout route
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});
Route::get('/', [AdminController::class, 'showProducts'])->name('home');

Route::post('/remove-product', [ProductController::class, 'removeProduct'])->name('admin.removeProduct');
Route::get('/admin/searchProduct/{id}', [AdminController::class, 'searchProduct']);
Route::post('/admin/updateProduct', [AdminController::class, 'updateProduct'])->name('admin.updateProduct');

Route::get('/filter-men', [ProductController::class, 'filterMen'])->name('filter.men');
Route::get('/filter-women', [ProductController::class, 'filterWomen'])->name('filter.women');
Route::get('/filter-unisex', [ProductController::class, 'filterUnisex'])->name('filter.unisex');

Route::get('/search', [ProductController::class, 'search'])->name('search');
Route::get('/store-locator', [StoreLocatorController::class, 'index'])->name('store-locator');

Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.detail');
Route::get('/admin/showProducts/{category}', [AdminController::class, 'showProducts']);

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/', [HomeProductController::class, 'showProducts'])->name('home');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.updatenew');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

Route::put('cart/update/{productKey}', [CartController::class, 'update'])->name('cart.update');
Route::delete('cart/remove/{productKey}', [CartController::class, 'remove'])->name('cart.removenew');
Route::get('/cart-count', [CartController::class, 'getCartCount']);
Route::get('/cart-slide', [CartController::class, 'getCartSlide']);

Route::get('/remove-from-cart/{id}', [CartController::class, 'removeFromCart'])->name('remove.from.cart');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout')->middleware('auth');
// Update the route name in web.php to match 'sub':
//Route::get('/sub', [SubscriptionController::class, 'Subscription'])->name('sub');

//Route::get('/subscription', [SubscriptionController::class, 'Subscription'])->name('sub');


Route::get('/check-subscription', function () {
    if (!Auth::check()) {
        // Redirect to login page with the intended URL to go back to after login
        return redirect()->route('login')->with('url.intended', route('subcription'));
    }

    // If user is already logged in, go to the subscription page
    return redirect()->route('subcritpion');
})->name('check-subscription');

Route::post('/order/confirm', [CheckoutController::class, 'confirmOrder'])->name('order.confirm');
require __DIR__.'/auth.php';


    Route::get('/menproduct', [MenController::class, 'MenProducts'])->name('menproduct');
    Route::post('/store-menproduct', [MenController::class, 'storeProduct'])->name('storemenproduct');
    Route::put('/update-menproduct/{id}', [MenController::class, 'updateProduct'])->name('updatemenproduct');
    Route::delete('/delete-menproduct/{id}', [MenController::class, 'destroyProduct'])->name('destroymenproduct');

    Route::get('/womenproduct', [WomenController::class, 'WomenProducts'])->name('womenproduct');
    Route::post('/store-womenproduct', [WomenController::class, 'storeProduct'])->name('storewomenproduct');
    Route::put('/update-womenproduct/{id}', [WomenController::class, 'updateProduct'])->name('updatewomenproduct'); 
    Route::delete('/delete-womenproduct/{id}', [WomenController::class, 'destroyProduct'])->name('destroywomenproduct');

    Route::get('/unisexproduct', [UniController::class, 'UnisexProducts'])->name('unisexproduct');
    Route::post('/store-unisexproduct', [UniController::class, 'storeProduct'])->name('storeunisexproduct');
    Route::put('/update-unisexproduct/{id}', [UniController::class, 'updateProduct'])->name('updateunisexproduct'); 
    Route::delete('/delete-unisexproduct/{id}', [UniController::class, 'destroyProduct'])->name('destroyunisexproduct');

    //display subscripton 
    Route::get('/subscription', [SubscriptionController::class, 'Subscription'])->name('subscription');
    
    //store subscription
    Route::post('/subscription/store', [SubscriptionController::class, 'store'])->name('subscription.store');
    //dispalay subscription in admin
    Route::get('/test-submit', [SubscriptionController::class, 'showSubscriptions'])->name('test-submit');

    //save order details in db and show in the admin page
    Route::post('/order/confirm', [OrderController::class, 'confirmOrder'])->name('order.confirm');

    //refill details
   // Route::post('/refill-details', [RefillDetailController::class, 'store'])->name('refill.store');
  // Route::get('/test-refill',   [RefillDetailController::class, 'refill'])->name('test-refill');



// Group routes that require authentication
//Route::middleware(['auth'])->group(function () {
      // Route to show the refill form
     // Route::get('/decantrefill', [RefillRequestController::class, 'create'])->name('refill.create');
    
      // Route to handle the form submission
     // Route::post('/refill/store', [RefillRequestController::class, 'store'])->name('refill.store');
    
    // Admin routes for managing refill requests
   // Route::get('/admin/refills', [RefillRequestController::class, 'index'])->name('admin.refilling');
    
    // Approve a refill request
   // Route::post('/admin/refills/{id}/approve', [RefillRequestController::class, 'approve'])->name('refill.approve');
    
    // Mark a refill request as paid
    //Route::post('/admin/refills/{id}/markPaid', [RefillRequestController::class, 'markPaid'])->name('refill.markPaid');
//});

Route::get('/refilling-request', [RefillRequestController::class, 'create'])->name('refilling_request.create');
Route::post('/refilling-request', [RefillRequestController::class, 'store'])->name('refilling_request.store');
Route::get('/admin/refilling', [RefillRequestController::class, 'adminView'])->name('admin.refilling');
Route::put('/admin/refilling/{refillRequest}', [RefillRequestController::class, 'update'])->name('admin.refilling.update');


// Payment routes
Route::get('/success', [StripeController::class, 'success'])->name('success');
Route::get('/cancel', [StripeController::class, 'cancel'])->name('cancel');
Route::post('/stripe', [StripeController::class, 'stripe'])->name('stripe');

// Admin refilling view with both refill requests and payment details
Route::get('/admin/refilling', [RefillRequestController::class, 'adminView'])->name('admin.refilling');


