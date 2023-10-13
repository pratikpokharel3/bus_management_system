<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Roboto Condensed', sans-serif;
        }

        table {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-gray {
            color: #5D5D5D;
        }

        .mt-1 {
            margin-top: 4px;
        }

        .mt-3 {
            margin-top: 12px;
        }

        .mt-4 {
            margin-top: 16px;
        }

        .mt-10 {
            margin-top: 40px;
        }

        .company_info {
            width: 50%;
            text-align: right;
            padding-left: 12px;
        }

        .table_header {
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            background-color: #F4F4F4;
        }

        .signature {
            padding-top: 48px;
            text-align: right;
        }

        .signature div {
            margin: 12px 37px 0 0;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <h2>Invoice</h2>
    </div>

    <table>
        <tbody>
            <tr>
                <td style="width: 50%">
                    <div class="font-bold">
                        Invoice Id: <span class="text-gray">#</span>
                    </div>

                    <div class="mt-1 font-bold">
                        Booking Id: <span class="text-gray">#{{ $booking->id }}</span>
                    </div>

                    <div class="mt-1 font-bold">
                        Booking Date: <span class="text-gray">
                            {{ \Carbon\Carbon::parse($booking->created_at)->format('Y/m/d') }}
                        </span>
                    </div>
                </td>
                <td class="company_info">
                    Purba Araniko Yatayat Sewa Samiti Pvt. Ltd.
                    <div class="mt-1">Lokanthali, Kathmandu, Nepal</div>
                    <div class="mt-1">+01-126859</div>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table
                        class="mt-3"
                        style="border: 1px solid #dfdfdf; border-collapse: collapse;"
                    >
                        <tbody>
                            <tr>
                                <td
                                    class="table_header"
                                    colspan="2"
                                >
                                    Booking Information
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 12px 12px 6px 12px;">Bus Name</td>
                                <td
                                    style="width: 50%; padding: 12px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->bus_departure)
                                        @isset($booking->bus_departure->bus)
                                            {{ $booking->bus_departure->bus->bus_name }}
                                        @else
                                            -
                                        @endisset
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 6px 12px;">Bus Route</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->bus_departure)
                                        @isset($booking->bus_departure->bus_route)
                                            {{ $booking->bus_departure->bus_route->source_location->district }} -
                                            {{ $booking->bus_departure->bus_route->destination_location->district }}
                                        @else
                                            -
                                        @endisset
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 6px 12px;">Number of Tickets Booked</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    {{ $booking->total_tickets }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 6px 12px;">Seats Booked</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    {{ implode(', ', explode(',', $booking->seats_booked)) }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 8px 12px;">Departure DateTime</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 8px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->bus_departure)
                                        {{ \Carbon\Carbon::parse($booking->bus_departure->departure_datetime)->format('jS, M Y \a\t h:i A') }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table
                        class="mt-4"
                        style="border: 1px solid #dfdfdf; border-collapse: collapse;"
                    >
                        <tbody>
                            <tr>
                                <td
                                    class="table_header"
                                    colspan="2"
                                >
                                    Customer Information
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 12px 12px 6px 12px;">Customer Name</td>
                                <td
                                    style="width: 50%; padding: 12px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->customer)
                                        {{ $booking->customer->name }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 6px 12px;">Phone Number</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->customer)
                                        {{ $booking->customer->phone_number }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 8px 12px;">Gender</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 8px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->customer)
                                        {{ ucwords($booking->customer->gender) }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 6px 12px;">Address</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->customer)
                                        {{ $booking->customer->location->district }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="2">
                    <table
                        class="mt-4"
                        style="border: 1px solid #dfdfdf; border-collapse: collapse;"
                    >
                        <tbody>
                            <tr>
                                <td
                                    class="table_header"
                                    colspan="2"
                                >
                                    Payment Information
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 12px 12px 6px 12px;">Bank Name</td>
                                <td
                                    style="width: 50%; padding: 12px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    @isset($booking->bank)
                                        {{ $booking->bank->bank_name }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 6px 12px;">Seat Per Price</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    Rs.
                                    @isset($booking->bus_departure)
                                        @isset($booking->bus_departure->bus_route)
                                            {{ number_format($booking->bus_departure->bus_route->price) }}
                                        @else
                                            -
                                        @endisset
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 6px 12px;">Total Amount</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 6px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    Rs. {{ number_format($booking->total_amount) }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 8px 12px 8px 12px;">VAT (13)%</td>
                                <td
                                    style="width: 50%; padding: 8px 12px 8px 12px; border-left: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    Rs. {{ number_format($booking->vat) }}
                                </td>
                            </tr>

                            <tr>
                                <td style="width: 50%; padding: 12px 12px 12px 12px; border-top: 1px solid #dfdfdf;">
                                    Grand Total</td>
                                <td
                                    style="width: 50%; padding: 12px 12px 12px 12px; border-left: 1px solid #dfdfdf; border-top: 1px solid #dfdfdf; text-align: end; font-weight: 600;">
                                    Rs. {{ number_format($booking->grand_total) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>

        <tfoot>
            <tr>
                <td
                    class="text-center"
                    colspan="2"
                >
                    <div class="signature">
                        _________________
                        <div>Signature</div>
                    </div>

                    <div class="mt-10">Note: Please bring this printed invoice when you arrive at the bus counter.
                    </div>
                    <div class="mt-1">Happy Safe Travelling</div>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
