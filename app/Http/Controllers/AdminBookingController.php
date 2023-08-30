<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\BusDeparture;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rules\Enum;

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

    public function update(Request $request, Booking $booking)
    {
        if ($request->booking_status === BookingStatus::REJECTED->value) {
            $request->validate(
                [
                    'booking_status' =>  ['required', new Enum(BookingStatus::class)],
                    'remarks' => 'required|max:255'
                ]
            );
        }

        if ($request->booking_status === BookingStatus::ACCEPTED->value) {
            $request->validate(['booking_status' =>  ['required', new Enum(BookingStatus::class)]]);
        }

        $bus_departure = BusDeparture::find($booking->departure_id);

        if ($request->booking_status === BookingStatus::ACCEPTED->value) {
            $bus_departure->total_tickets_booked += $booking->total_tickets;

            if ($bus_departure->seats_booked == null) {
                $bus_departure->seats_booked = $booking->seats_booked;
            } else {
                $bus_departure->seats_booked .= ',' . $booking->seats_booked;
            }
        }

        $result = array_diff(explode(',', $bus_departure->pending_seats), explode(',', $booking->seats_booked));
        $bus_departure->pending_seats = implode(',', $result);

        if ($bus_departure->pending_seats === '') {
            $bus_departure->pending_seats = null;
        }

        $bus_departure->save();

        $booking->booking_status = $request->booking_status;

        if ($request->booking_status === BookingStatus::ACCEPTED->value) {
            $booking->remarks = 'Congratulations! Your booking has been confirmed.';
        } else if (BookingStatus::REJECTED->value === $request->booking_status) {
            $booking->remarks = $request->remarks;
        }

        $booking->save();

        if ($request->booking_status === BookingStatus::ACCEPTED->value) {
            $payment = Payment::where('booking_id', $booking->id)->first();
            $payment->payment_status = PaymentStatus::PAID->value;
            $payment->save();
        }

        return back()->with('success', 'Booking Status Updated Succesfully.');
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
