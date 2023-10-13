<?php

namespace App\Http\Controllers;

use App\Models\BusRoute;
use App\Models\Location;
use Illuminate\Http\Request;

class AdminBusRouteController extends Controller
{
    public function index()
    {
        $bus_routes = BusRoute::with(
            'source_location',
            'destination_location',
            'user'
        )
            ->latest()
            ->paginate(10);

        return view('bus_route.index', [
            'bus_routes' => $bus_routes
        ]);
    }

    public function create()
    {
        return view('bus_route.create', [
            'locations' => Location::all()
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate(
            [
                'source_location_id' => 'required',
                'destination_location_id' => 'required',
                'price' => 'required|integer|gt:0'
            ],
            [
                'source_location_id.required' => 'The source location field is required.',
                'destination_location_id.required' => 'The destination location field is required.',
            ]
        );

        $attributes['user_id'] = auth()->id();
        BusRoute::create($attributes);

        return back()->with('success', 'Bus Route Added Successfully.');
    }

    public function edit(BusRoute $bus_route)
    {
        return view('bus_route.edit', [
            'bus_route' => $bus_route->load('source_location', 'destination_location'),
            'locations' => Location::all()
        ]);
    }

    public function update(BusRoute $bus_route, Request $request)
    {
        $attributes = $request->validate(
            [
                'source_location_id' => 'required',
                'destination_location_id' => 'required',
                'price' => 'required|integer|gt:0'
            ],
            [
                'source_location_id.required' => 'The source location field is required.',
                'destination_location_id.required' => 'The destination location field is required.',
            ]
        );

        $attributes['user_id'] = auth()->id();
        $bus_route->update($attributes);

        return back()->with('success', 'Bus Route Information Updated Successfully.');
    }

    public function destroy(BusRoute $bus_route)
    {
        $bus_route->delete();

        return back()->with('success', 'Bus Route Deleted Successfully.');
    }
}
