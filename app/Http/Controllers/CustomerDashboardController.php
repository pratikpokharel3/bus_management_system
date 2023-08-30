<?php

namespace App\Http\Controllers;

use App\Models\BusDeparture;

class CustomerDashboardController extends Controller
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

        return view('customer.dashboard', [
            'bus_departures' => $bus_departures
        ]);
    }
}
