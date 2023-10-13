<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusRoute;
use App\Models\BusDeparture;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;

use App\Enums\UserRole;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $total_buses = Bus::count();
        $total_bus_routes = BusRoute::count();
        $total_bus_departures = BusDeparture::count();
        $total_bookings = Booking::count();
        $total_payments = Payment::count();
        $total_customers = User::where("user_role", UserRole::CUSTOMER->value)->count();

        return view('dashboard', [
            'total_buses' => $total_buses,
            'total_bus_routes' => $total_bus_routes,
            'total_bus_departures' => $total_bus_departures,
            'total_bookings' => $total_bookings,
            'total_payments' => $total_payments,
            'total_customers' => $total_customers,
        ]);
    }
}
