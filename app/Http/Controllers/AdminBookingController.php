<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(
            'customer',
            'bus_departure.bus_route.source_location',
            'bus_departure.bus_route.destination_location'
        )
            ->latest()
            ->filter(request(['search']))
            ->paginate(10);

        return view('booking.index', [
            'bookings' => $bookings
        ]);
    }

    public function show(Booking $booking)
    {
        return view('booking.show', [
            'booking' => $booking->load(
                'bus_departure.bus',
                'bus_departure.bus_route.source_location',
                'bus_departure.bus_route.destination_location',
                'bank'
            ),
        ]);
    }

    public function invoice_view(Booking $booking)
    {
        return Pdf::loadView('customer.booking.invoice', [
            'booking' => $booking->load(
                'bus_departure.bus',
                'bus_departure.bus_route',
                'bus_departure.bus_route.source_location',
                'bus_departure.bus_route.destination_location',
                'bank'
            )
        ])->stream('booking_invoice.pdf');
    }

    public function invoice_download(Booking $booking)
    {
        return PDF::loadView(
            'customer.booking.invoice',
            [
                'booking' => $booking->load(
                    'bus_departure.bus',
                    'bus_departure.bus_route',
                    'bus_departure.bus_route.source_location',
                    'bus_departure.bus_route.destination_location',
                    'bank'
                )
            ]
        )->download('booking_invoice.pdf');
    }
}
