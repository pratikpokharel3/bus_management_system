<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Enums\BusStatus;
use App\Models\BusRoute;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class AdminBusController extends Controller
{
    public function index()
    {
        $buses = Bus::with('bus_route.source_location', 'bus_route.destination_location')
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return view('bus.index', [
            'buses' => $buses
        ]);
    }

    public function create()
    {
        $bus_routes = BusRoute::with('source_location', 'destination_location')->get();

        return view('bus.create', [
            'bus_routes' => $bus_routes
        ]);
    }

    public function store(Request $request)
    {
        $attributes = $request->validate(
            [
                'bus_name' => 'required|max:255',
                'total_seats' => 'required|integer|gt:0',
                'bus_plate_number' => 'required|max:255|unique:buses,bus_plate_number',
                'driver_name' => 'required|max:255',
                'conductor_name' => 'required|max:255',
                'bus_owner' => 'required|max:255',
                'bus_status' =>  ['required', new Enum(BusStatus::class)],
                'bus_route_id' => 'required'
            ],
            [
                'bus_route_id.required' => 'The bus route field is required.'
            ]
        );

        $attributes['user_id'] = auth()->id();
        Bus::create($attributes);
        return back()->with('success', 'Bus Information Added Successfully.');
    }

    public function show(Bus $bus)
    {
        return view('bus.show', [
            'bus' => $bus->load(
                'user',
                'bus_route.source_location',
                'bus_route.destination_location'
            )
        ]);
    }

    public function edit(Bus $bus)
    {
        $bus_routes = BusRoute::with('source_location', 'destination_location')->get();

        return view('bus.edit', [
            'bus' => $bus,
            'bus_routes' => $bus_routes
        ]);
    }

    public function update(Request $request, Bus $bus)
    {
        $attributes = $request->validate(
            [
                'bus_name' => 'required|max:255',
                'total_seats' => 'required|integer|gt:0',
                'bus_plate_number' => 'required|max:255|unique:buses,bus_plate_number,' .  $bus->id,
                'driver_name' => 'required|max:255',
                'conductor_name' => 'required|max:255',
                'bus_owner' => 'required|max:255',
                'bus_status' =>  ['required', new Enum(BusStatus::class)],
                'bus_route_id' => 'required'
            ],
            [
                'bus_route_id.required' => 'The bus route field is required.'
            ]
        );

        $attributes['user_id'] = auth()->id();
        $bus->update($attributes);

        return back()->with('success', 'Bus Information Updated Successfully.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();

        return back()->with('success', 'Bus Information Deleted Successfully.');
    }
}
