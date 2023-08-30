<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\BusDeparture;

class HomeController extends Controller
{
    public function index()
    {
        $locations = Location::all();
        $bus_departures = BusDeparture::with(
            'bus',
            'bus_route.source_location',
            'bus_route.destination_location'
        )
            ->whereDate('departure_datetime', '>=', date('Y-m-d'))
            ->take(5)
            ->get();

        return view('guest.home', [
            'locations' => $locations,
            'bus_departures' => $bus_departures
        ]);
    }
}
