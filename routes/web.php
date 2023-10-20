<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminEnquiryController;

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminBusController;
use App\Http\Controllers\AdminBusRouteController;
use App\Http\Controllers\AdminBusDepartureController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminCustomerController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::GET('/', function () {
    return redirect("/login");
});

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::group([
        'prefix' => 'admin',
        'as' => 'admin.'
    ], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('buses', [AdminBusController::class, 'index'])->name('bus.index');
        Route::get('buses/create', [AdminBusController::class, 'create'])->name('bus.create');
        Route::post('buses', [AdminBusController::class, 'store'])->name('bus.store');
        Route::get('buses/{bus}', [AdminBusController::class, 'show'])->name('bus.show');
        Route::get('buses/{bus}/edit', [AdminBusController::class, 'edit'])->name('bus.edit');
        Route::patch('buses/{bus}', [AdminBusController::class, 'update'])->name('bus.update');
        Route::delete('buses/{bus}', [AdminBusController::class, 'destroy'])->name('bus.destroy');

        Route::get('bus_routes', [AdminBusRouteController::class, 'index'])->name('bus_route.index');
        Route::get('bus_routes/create', [AdminBusRouteController::class, 'create'])->name('bus_route.create');
        Route::post('bus_routes', [AdminBusRouteController::class, 'store'])->name('bus_route.store');
        Route::get('bus_routes/{bus_route}/edit', [AdminBusRouteController::class, 'edit'])->name('bus_route.edit');
        Route::patch('bus_routes/{bus_route}', [AdminBusRouteController::class, 'update'])->name('bus_route.update');
        Route::delete('bus_routes/{bus_route}', [AdminBusRouteController::class, 'destroy'])->name('bus_route.destroy');

        Route::get('bus_departures', [AdminBusDepartureController::class, 'index'])->name('bus_departure.index');
        Route::get('bus_departures/create', [AdminBusDepartureController::class, 'create'])->name('bus_departure.create');
        Route::post('bus_departures', [AdminBusDepartureController::class, 'store'])->name('bus_departure.store');
        Route::get('bus_departures/{bus_departure}', [AdminBusDepartureController::class, 'show'])->name('bus_departure.show');
        Route::get('bus_departures/{bus_departure}/edit', [AdminBusDepartureController::class, 'edit'])->name('bus_departure.edit');
        Route::patch('bus_departures/{bus_departure}', [AdminBusDepartureController::class, 'update'])->name('bus_departure.update');

        Route::get('bookings', [AdminBookingController::class, 'index'])->name('booking.index');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('booking.show');
        Route::post('bookings/invoice/{booking}', [AdminBookingController::class, 'invoice_view'])->name('booking.invoice.view');
        Route::post('bookings/invoice/{booking}/download', [AdminBookingController::class, 'invoice_download'])->name('booking.invoice.download');

        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payment.index');

        Route::get('customers', [AdminCustomerController::class, 'index'])->name('customer.index');
        Route::get('customers/{customer}', [AdminCustomerController::class, 'show'])->name('customer.show');

        Route::get('users', [AdminUserController::class, 'index'])->name('user.index');
        Route::get('users/create', [AdminUserController::class, 'create'])->name('user.create');
        Route::post('users', [AdminUserController::class, 'store'])->name('user.store');
        Route::get('users/{user}', [AdminUserController::class, 'show'])->name('user.show');
        Route::patch('users/{user}', [AdminUserController::class, 'update'])->name('user.update');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('user.destroy');

        Route::get('enquiries', [AdminEnquiryController::class, 'index'])->name('enquiry.index');
        Route::delete('enquiries/{enquiry}', [AdminEnquiryController::class, 'destroy'])->name('enquiry.destroy');
    });
});

require __DIR__ . '/auth.php';
