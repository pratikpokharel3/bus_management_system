<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Payment;
use App\Models\Booking;
use App\Models\BusRoute;
use App\Models\BusDeparture;
use App\Models\CustomersBankInformation;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Resources\CustomAPIResource;

class CustomerBookingController extends Controller
{
    public function index()
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

        return view('customer.booking.index', [
            'bookings' => $bookings,
        ]);
    }

    public function create()
    {
        $user = auth()->user();

        $bank = CustomersBankInformation::where('customer_id', auth()->id())->first();

        $kyc_information = [
            'is_kyc_verified' => true,
            'message' => 'KYC Verified'
        ];

        if ($user->phone_number === null || $user->gender === null || $user->location_id === null || $bank === null) {
            $kyc_information = [
                'is_kyc_verified' => false,
                'message' => '<div>Before you can create booking, you need to update your KYC information (including your bank account).</div> 
                <div>Head over to your <a class="font-semibold underline" href="/profile">Account Profile</a> and update your KYC information.</div>'
            ];
        }

        return view(
            'customer.booking.create',
            [
                'kyc_information' => $kyc_information,
            ]
        );
    }

    public function show(Booking $booking)
    {
        return view(
            'customer.booking.show',
            [
                'booking' => $booking->load(
                    'bus_departure.bus',
                    'bus_departure.bus_route.source_location',
                    'bus_departure.bus_route.destination_location',
                    'bank'
                )
            ]
        );
    }

    public function destroy(Booking $booking)
    {
        $bus_departure = BusDeparture::find($booking->departure_id);

        $totalHours = Carbon::parse($bus_departure->departure_datetime)->diffInHours(now());

        if ($totalHours < 2) {
            return back()->with('booking_delete', '<div>Your booking can only be cancelled before 2 hours left of departure time.</div>
            <div>Please, contact our tech support for more information regarding booking cancellation and refund.</div>');
        }

        if ($booking->booking_status == BookingStatus::PENDING->value) {
            $result = array_diff(explode(',', $bus_departure->pending_seats), explode(',', $booking->seats_booked));
            $bus_departure->pending_seats = implode(',', $result);

            if ($bus_departure->pending_seats === '') {
                $bus_departure->pending_seats = null;
            }
        }

        if ($booking->booking_status == BookingStatus::ACCEPTED->value) {
            $bus_departure->total_tickets_booked -= $booking->total_tickets;

            $result = array_diff(explode(',', $bus_departure->seats_booked), explode(',', $booking->seats_booked));
            $bus_departure->seats_booked = implode(',', $result);

            if ($bus_departure->seats_booked === '') {
                $bus_departure->seats_booked = null;
            }
        }

        $bus_departure->save();
        $booking->delete();

        return redirect('customer/bookings')->with('success', 'Booking Information Deleted Successfully.');
    }

    public function check_bus_departures(Request $request)
    {
        $request->validate([
            'source_location_id' => 'required',
            'destination_location_id' => 'required',
            'departure_datetime' => 'required|date|date_format:Y-m-d'
        ]);

        $bus_departures = BusDeparture::whereHas('bus_route', function ($query) use ($request) {
            $query->where('source_location_id', $request->source_location_id)
                ->where('destination_location_id', $request->destination_location_id);
        })
            ->whereDate('departure_datetime', date('Y-m-d', strtotime($request->departure_datetime)))
            ->with('bus', 'bus_route.source_location', 'bus_route.destination_location')
            ->get();

        return new CustomAPIResource($bus_departures);
    }

    public function check_bus_seats_availabilty(Request $request)
    {
        $bus_departure = BusDeparture::with(
            'bus_route.source_location',
            'bus_route.destination_location'
        )
            ->find($request->departure_id);

        $bus = Bus::find($bus_departure->bus_id);

        $are_tickets_already_booked = $bus_departure->total_tickets_booked >= $bus->total_seats;

        if ($are_tickets_already_booked) {
            return new CustomAPIResource([
                'message' => 'All tickets have been booked. Please try another bus!'
            ]);
        }

        $booked_seats = [];
        $pending_seats = [];

        if ($bus_departure->seats_booked !== null) {
            $booked_seats = explode(',', $bus_departure->seats_booked);
        }

        if ($bus_departure->pending_seats !== null) {
            $pending_seats = explode(',', $bus_departure->pending_seats);
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
        ];

        return new CustomAPIResource([
            'bus' => $bus,
            'bus_departure' => $bus_departure,
            'seat_planning' => $seat_planning,
            'booked_seats' => $booked_seats,
            'pending_seats' => $pending_seats
        ]);
    }

    public function confirm_booking(Request $request)
    {
        $bus_departure = BusDeparture::find($request->departure_id);
        $bus_route = BusRoute::find($bus_departure->bus_route_id);

        $total_amount = $bus_route->price * $request->number_of_seats;
        $vat = 0.13 * $total_amount;
        $grand_total = $total_amount + $vat;

        return new CustomAPIResource([
            'seat_per_price' => $bus_route->price,
            'total_amount' => $total_amount,
            'vat' => $vat,
            'grand_total' => $grand_total
        ]);
    }

    public function confirm_payment(Request $request)
    {
        $bus_departure = BusDeparture::find($request->departure_id);

        $user_booked_seats = [];
        $booked_seats = [];
        $pending_seats = [];

        $user_booked_seats = explode(',', $request->seats_booked);

        if ($bus_departure->seats_booked !== null) {
            $booked_seats = explode(',', $bus_departure->seats_booked);
        }

        if ($bus_departure->pending_seats !== null) {
            $pending_seats = explode(',', $bus_departure->pending_seats);
        }

        //Check to see if seats have already been booked
        $result1 = array_intersect($user_booked_seats, $pending_seats);
        $result2 = array_intersect($user_booked_seats, $booked_seats);

        if (count($result1) || count($result2)) {
            $result = array_merge($result1, $result2);
            $message = 'The seats ' . implode(',', $result) . ' has already been booked. Please try another seats for your booking.';

            return back()->with('booking', $message);
        }

        $bus_route = BusRoute::find($bus_departure->bus_route_id);

        $total_amount = $bus_route->price * $request->total_tickets;
        $vat = 0.13 * $total_amount;
        $grand_total = $total_amount + $vat;

        if ($bus_departure->pending_seats == null) {
            $bus_departure->pending_seats = $request->seats_booked;
        } else {
            $bus_departure->pending_seats .= ',' . $request->seats_booked;
        }

        $bus_departure->save();

        $booking = new Booking([
            'departure_id' => $bus_departure->id,
            'total_tickets' => $request->total_tickets,
            'seats_booked' => $request->seats_booked,
            'total_amount' => $total_amount,
            'vat' => $vat,
            'grand_total' => $grand_total,
            'remarks' => "Your booking is being reviewed. We'll inform you about your booking confirmation after processing."
        ]);

        $booking['customer_id'] = auth()->user()->id;
        $booking->save();

        Payment::create([
            'booking_id' => $booking->id,
            'customer_id' => auth()->id(),
            'payment_status' => PaymentStatus::NOT_PAID->value,
            'paid_amount' => $grand_total,
        ]);

        return back()->with('success', 'Payment Completed Successfully.');
    }

    public function invoice_view(Booking $booking)
    {
        return Pdf::loadView('customer.booking.invoice', [
            'booking' => $booking->load(
                'bus_departure.bus',
                'bus_departure.bus_route',
                'bus_departure.bus_route.source_location',
                'bus_departure.bus_route.destination_location',
                'customer',
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
                    'customer',
                    'customer_bank.bank'
                )
            ]
        )->download('booking_invoice.pdf');
    }
}
