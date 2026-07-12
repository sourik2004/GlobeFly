<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', function () {
    $packages = \App\Models\TourPackage::where('status', 'active')->latest()->take(3)->get();
    $hotels = \App\Models\Hotel::latest()->take(3)->get();
    $destinations = \App\Models\Destination::latest()->take(4)->get();
    return view('home', compact('packages', 'hotels', 'destinations'));
})->name('home');

Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{id}', [TourController::class, 'show'])->name('tours.show');

Route::get('/hotels', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotels/{id}', [HotelController::class, 'show'])->name('hotels.show');

Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // Core Dashboard Route (Role router)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Bookings & Payments
    Route::get('/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/bookings', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

    // Traveler Specific Routes
    Route::middleware(['role:traveler'])->group(function () {
        // AI Planner
        Route::get('/ai-planner', [TripController::class, 'planner'])->name('trip.planner');
        Route::post('/ai-planner/generate', [TripController::class, 'generate'])->name('trip.generate');
        
        // Saved Trips
        Route::post('/trips', [TripController::class, 'store'])->name('trip.store');
        Route::get('/trips/{id}', [TripController::class, 'show'])->name('trip.show');
        Route::delete('/trips/{id}', [TripController::class, 'destroy'])->name('trip.destroy');

        // Travel Expenses
        Route::post('/expenses', [ExpenseController::class, 'store'])->name('expense.store');
        Route::delete('/expenses/{id}', [ExpenseController::class, 'destroy'])->name('expense.destroy');

        // AI Chatbot
        Route::get('/ai-chat', [ChatController::class, 'index'])->name('chat.index');
        Route::post('/ai-chat/send', [ChatController::class, 'store'])->name('chat.store');
    });

    // Tour Manager Specific Routes
    Route::middleware(['role:tour_manager'])->group(function () {
        Route::get('/tours/manage/create', [TourController::class, 'create'])->name('tours.create');
        Route::post('/tours/manage', [TourController::class, 'store'])->name('tours.store');
        Route::get('/tours/manage/{id}/edit', [TourController::class, 'edit'])->name('tours.edit');
        Route::put('/tours/manage/{id}', [TourController::class, 'update'])->name('tours.update');
        Route::delete('/tours/manage/{id}', [TourController::class, 'destroy'])->name('tours.destroy');
        
        Route::post('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('booking.status');
    });

    // Hotel Partner Specific Routes
    Route::middleware(['role:hotel_partner'])->group(function () {
        Route::get('/hotels/manage/create', [HotelController::class, 'create'])->name('hotels.create');
        Route::post('/hotels/manage', [HotelController::class, 'store'])->name('hotels.store');
        Route::get('/hotels/manage/{id}/edit', [HotelController::class, 'edit'])->name('hotels.edit');
        Route::put('/hotels/manage/{id}', [HotelController::class, 'update'])->name('hotels.update');
        Route::delete('/hotels/manage/{id}', [HotelController::class, 'destroy'])->name('hotels.destroy');
        
        Route::get('/hotels/manage/{hotelId}/rooms/create', [HotelController::class, 'createRoom'])->name('hotels.rooms.create');
        Route::post('/hotels/manage/{hotelId}/rooms', [HotelController::class, 'storeRoom'])->name('hotels.rooms.store');
        Route::get('/hotels/manage/rooms/{roomId}/edit', [HotelController::class, 'editRoom'])->name('hotels.rooms.edit');
        Route::put('/hotels/manage/rooms/{roomId}', [HotelController::class, 'updateRoom'])->name('hotels.rooms.update');
        Route::delete('/hotels/manage/rooms/{roomId}', [HotelController::class, 'destroyRoom'])->name('hotels.rooms.destroy');
        
        Route::post('/partner/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('partner.booking.status');
    });

    // Admin Specific Routes
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/admin/destinations', [AdminController::class, 'storeDestination'])->name('admin.destinations.store');
        Route::put('/admin/destinations/{id}', [AdminController::class, 'updateDestination'])->name('admin.destinations.update');
        Route::delete('/admin/destinations/{id}', [AdminController::class, 'destroyDestination'])->name('admin.destinations.destroy');
        Route::post('/admin/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
    });
});

require __DIR__.'/auth.php';
