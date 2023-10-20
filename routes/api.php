<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminEnquiryController;
use App\Http\Controllers\CustomerLoginController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\CustomerPaymentController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\AdminBusDepartureController;
use App\Http\Controllers\CustomerBankInformationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get("user", [CustomerLoginController::class, 'check_user']);
Route::post("login", [CustomerLoginController::class, 'login']);
Route::post("register", [CustomerLoginController::class, 'register']);
Route::post("logout", [CustomerLoginController::class, 'logout']);

Route::get('bus_departures', [AdminBusDepartureController::class, 'get_all_bus_departures']);
Route::get('bus_departures/{bus_departure_id}', [CustomerBookingController::class, 'get_bus_departure']);
Route::post('ticket_booking_detail', [CustomerBookingController::class, 'ticket_booking_detail']);

Route::post('customer_enquiries', [AdminEnquiryController::class, 'store']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('user/bookings', [CustomerBookingController::class, 'get_all_bookings']);
    Route::post('user/bookings', [CustomerBookingController::class, 'store_booking']);
    Route::get('user/bookings/{booking_id}', [CustomerBookingController::class, 'show_booking']);
    Route::delete('user/bookings/{booking_id}', [CustomerBookingController::class, 'delete_booking']);
    Route::get('user/bookings/{booking_id}/invoice', [CustomerBookingController::class, 'invoice_download']);

    Route::get('user/payments', [CustomerPaymentController::class, 'get_all_payments']);

    Route::get('user/profile', [CustomerProfileController::class, 'get_profile_info']);
    Route::post('user/profile', [CustomerProfileController::class, 'store_profile_info']);

    Route::get('locations', [CustomerProfileController::class, 'get_locations']);
    Route::get('banks', [CustomerBankInformationController::class, 'get_all_banks']);
});
