<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\BusRoute;
use App\Models\BusDeparture;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class CustomerBookingController extends Controller
{
    public function get_all_bookings()
    {
        $bookings = Booking::where('customer_id', auth()->id())
            ->with(
                [
                    'bus_departure.bus',
                    'bus_departure.bus_route.source_location',
                    'bus_departure.bus_route.destination_location'
                ]
            )
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return response()->json($bookings);
    }

    public function get_bus_departure($bus_departure_id)
    {
        $bus_departure = BusDeparture::with(
            'bus',
            'bus_route.source_location',
            'bus_route.destination_location'
        )->find($bus_departure_id);

        if ($bus_departure === null) {
            return response()->json([
                'bus_departure' => null,
                'seat_planning' => [],
                'seats_booked' => []
            ]);
        }

        $seats_booked = [];

        if ($bus_departure->seats_booked !== null) {
            $seats_booked = explode(',', $bus_departure->seats_booked);
        }

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

        return response()->json([
            'bus_departure' => $bus_departure,
            'seat_planning' => $seat_planning,
            'seats_booked' => $seats_booked
        ]);
    }

    public function ticket_booking_detail(Request $request)
    {
        $bus_departure = BusDeparture::find($request->departure_id);

        $seats_booked = [];

        if ($bus_departure->seats_booked !== null) {
            $seats_booked = explode(',', $bus_departure->seats_booked);
        }

        //Check to see if seats have already been booked
        $result = array_intersect($request->seats_booked, $seats_booked);

        if (count($result)) {
            $message = 'The seats ' . implode(', ', $result) . ' has already been booked. Please try another seats for your booking.';

            return response()->json([
                'seats_already_booked' => true,
                'seats_booked' => explode(",", $bus_departure->seats_booked),
                'message' => $message
            ]);
        }

        $bus_route = BusRoute::find($bus_departure->bus_route_id);

        $total_amount = $bus_route->price * count($request->seats_booked);
        $vat = 0.13 * $total_amount;
        $grand_total = $total_amount + $vat;

        return response()->json([
            'seat_per_price' => $bus_route->price,
            'total_amount' => $total_amount,
            'vat' => $vat,
            'grand_total' => $grand_total
        ]);
    }

    public function store_booking(Request $request)
    {
        $bus_departure = BusDeparture::find($request->departure_id);

        $bus_route = BusRoute::find($bus_departure->bus_route_id);

        $total_amount = $bus_route->price * count($request->seats_booked);
        $vat = 0.13 * $total_amount;
        $grand_total = $total_amount + $vat;

        $bus_departure->total_tickets += count($request->seats_booked);

        if ($bus_departure->seats_booked == null) {
            $bus_departure->seats_booked = implode(",", $request->seats_booked);
        } else {
            $bus_departure->seats_booked .= "," . implode(",", $request->seats_booked);
        }

        $bus_departure->save();

        $booking = new Booking([
            'customer_id' => auth()->id(),
            'departure_id' => $bus_departure->id,
            'total_tickets' => count($request->seats_booked),
            'seats_booked' => implode(",", $request->seats_booked),
            'total_amount' => $total_amount,
            'vat' => $vat,
            'grand_total' => $grand_total,
        ]);

        $booking->save();

        Payment::create([
            'booking_id' => $booking->id,
            'customer_id' => auth()->id(),
            'paid_amount' => $grand_total,
        ]);

        return response()->json([
            'payment_success' => true,
            'message' => 'Payment is succesfull. Booking is Confirmed!'
        ]);
    }

    public function show_booking($booking_id)
    {
        $booking = Booking::with(
            'bus_departure.bus',
            'bus_departure.bus_route.source_location',
            'bus_departure.bus_route.destination_location',
            'bank'
        )->find($booking_id);

        return response()->json($booking);
    }

    public function delete_booking($booking_id)
    {
        $booking = Booking::find($booking_id);
        $bus_departure = BusDeparture::find($booking->departure_id);

        $totalHours = Carbon::parse($bus_departure->departure_datetime)->diffInHours(now());

        //Do not allow customers to cancel bus tickets before 2 hours of departure datetime
        if ($totalHours < 2) {
            return response()->json([
                'booking_status' => false,
                'message' => 'Your booking can only be cancelled before 2 hours of departure datetime. Please, contact our tech support for more information about this situation.'
            ]);
        }

        $bus_departure->total_tickets -= $booking->total_tickets;

        if ($bus_departure->total_tickets == 0) {
            $bus_departure->total_tickets = null;
        }

        $result = array_diff(explode(',', $bus_departure->seats_booked), explode(',', $booking->seats_booked));
        $bus_departure->seats_booked = implode(',', $result);

        if ($bus_departure->seats_booked === '') {
            $bus_departure->seats_booked = null;
        }

        $bus_departure->save();
        $booking->delete();

        return response()->json([
            'message' => 'Booking Cancelled Successfully.'
        ]);
    }

    public function invoice_download($booking_id)
    {
        $booking = Booking::with(
            'bus_departure.bus',
            'bus_departure.bus_route',
            'bus_departure.bus_route.source_location',
            'bus_departure.bus_route.destination_location',
            'customer',
            'bank'
        )->find($booking_id);

        return PDF::loadView('booking.invoice', [
            'booking' => $booking
        ])->download();
    }
}
