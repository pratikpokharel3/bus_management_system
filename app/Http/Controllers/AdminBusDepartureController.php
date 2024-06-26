<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\BusRoute;
use App\Enums\BusStatus;
use App\Models\BusDeparture;
use Illuminate\Http\Request;
use App\Enums\BusDepartureStatus;
use Illuminate\Validation\Rules\Enum;

class AdminBusDepartureController extends Controller
{
    public function index()
    {
        $bus_departures = BusDeparture::with(
            'bus',
            'bus_route.source_location',
            'bus_route.destination_location'
        )
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return view('bus_departure.index', [
            'bus_departures' => $bus_departures
        ]);
    }

    public function create()
    {
        $buses = Bus::where('bus_status', BusStatus::AVAILABLE->value)->get();
        $bus_routes = BusRoute::with('source_location', 'destination_location')->get();

        return view('bus_departure.create', [
            'buses' => $buses,
            'bus_routes' => $bus_routes
        ]);
    }

    public function store(Request $request)
    {
        //DateTime format: 2023-05-06T15:41
        $attributes = $request->validate(
            [
                'bus_id' => 'required',
                'bus_route_id' => 'required',
                'departure_datetime' => 'required|date|date_format:Y-m-d\TH:i|after:now'
            ],
            [
                'bus_id.required' => 'The bus name field is required.',
                'bus_route_id.required' => 'The bus route field is required.',
                'departure_datetime.date_format' => 'The departure datetime field format is invalid.',
                'departure_datetime.after' => 'The departure datetime field must be greater than current datetime.'
            ]
        );

        $attributes['total_tickets'] = null;
        $attributes['seats_booked'] = null;

        $date = Carbon::createFromFormat('Y-m-d\TH:i', $request->departure_datetime);
        $attributes['departure_datetime'] = $date;

        $attributes['departure_status'] = BusDepartureStatus::NOT_STARTED->value;
        $attributes['user_id'] = auth()->id();

        BusDeparture::create($attributes);
        return back()->with('success', 'Bus Departure Information Added Successfully.');
    }

    public function show(BusDeparture $bus_departure)
    {
        $seat_planning = [
            ['A1', 'A2', 'B1', 'B2'],
            ['A3', 'A4', 'B3', 'B4'],
            ['A5', 'A6', 'B5', 'B6'],
            ['A7', 'A8', 'B7', 'B8'],
            ['A9', 'A10', 'B9', 'B10'],
            ['A11', 'A12', 'B11', 'B12'],
            ['A13', 'A14', 'B13', 'B14'],
            ['A15', 'A16', 'B15', 'B16'],
            ['A17', 'A18', 'B17', 'B18'],
            ['A19', 'A20', 'B19', 'B20'],
        ];

        return view('bus_departure.show', [
            'bus_departure' => $bus_departure->load(
                'bus',
                'bus_route.source_location',
                'bus_route.destination_location',
                'user'
            ),
            'seat_planning' => $seat_planning
        ]);
    }

    public function edit(BusDeparture $bus_departure)
    {
        $buses = Bus::all();
        $bus_routes = BusRoute::with('source_location', 'destination_location')->get();

        return view('bus_departure.edit', [
            'buses' => $buses,
            'bus_routes' => $bus_routes,
            'bus_departure' => $bus_departure->load('bus')
        ]);
    }

    public function update(Request $request, BusDeparture $bus_departure)
    {
        $attributes = [];

        if ($bus_departure->departure_status === BusDepartureStatus::NOT_STARTED->value && $bus_departure->seats_booked === null) {
            $attributes = $request->validate(
                [
                    'bus_id' => 'required',
                    'bus_route_id' => 'required',
                    'departure_datetime' => 'required|date|date_format:Y-m-d\TH:i|after:now',
                    'departure_status' => ['required', new Enum(BusDepartureStatus::class)],
                ],
                [
                    'bus_id.required' => 'The bus name field is required.',
                    'bus_route_id.required' => 'The bus route field is required.',
                    'departure_datetime.date_format' => 'The departure datetime field format is invalid.',
                    'departure_datetime.after' => 'The departure datetime field must be greater than current datetime.'
                ]
            );
        }

        if ($bus_departure->departure_status === BusDepartureStatus::NOT_STARTED->value && $bus_departure->seats_booked !== null) {
            $attributes = $request->validate(
                [
                    'departure_status' => ['required', new Enum(BusDepartureStatus::class)],
                ],
            );
        }

        if ($bus_departure->departure_status === BusDepartureStatus::PENDING->value) {
            $attributes = $request->validate(
                [
                    'departure_status' => ['required', new Enum(BusDepartureStatus::class)],
                ],
            );
        }

        $bus_departure->user_id = auth()->user()->id;
        $bus_departure->update($attributes);

        return back()->with('success', 'Bus Departure Information Updated Successfully.');
    }

    public function destroy(BusDeparture $bus_departure)
    {
        $bus_departure->delete();

        return back()->with('success', 'Bus Departure Information Deleted Successfully.');
    }

    public function get_all_bus_departures()
    {
        $bus_departures = BusDeparture::with(
            'bus',
            'bus_route.source_location',
            'bus_route.destination_location'
        )
            ->where('departure_status', BusDepartureStatus::NOT_STARTED)
            ->whereDate("departure_datetime", ">=", now()->format("Y-m-d"))
            ->latest()
            ->paginate(10);

        return response()->json($bus_departures);
    }
}
