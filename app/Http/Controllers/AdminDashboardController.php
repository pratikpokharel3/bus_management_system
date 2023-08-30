<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Booking;
use App\Models\BusDeparture;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $bus_departures = BusDeparture::with(
            'bus',
            'bus_route.source_location',
            'bus_route.destination_location'
        )
            ->whereDate('departure_datetime', '>=', date('Y-m-d'))
            ->latest()
            ->take(5)->get();

        $buses = Bus::latest()->take(5)->get();

        $bookings = Booking::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'bus_departures' => $bus_departures,
            'buses' => $buses,
            'bookings' => $bookings
        ]);
    }
}
