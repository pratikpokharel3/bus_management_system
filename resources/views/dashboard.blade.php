<x-app-layout>
    <div class="m-8 overflow-hidden rounded-lg bg-white p-6">
        <x-page-header>Dashboard</x-page-header>

        <div class="mt-4 text-lg font-semibold">Bus Departures</div>

        <div class="mt-2 overflow-x-auto rounded-lg border">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Bus Name</th>
                        <th class="px-6 py-3">Source-Destination</th>
                        <th class="px-6 py-3">Departure DateTime</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bus_departures as $bus_departure)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                @isset($bus_departure->bus)
                                    {{ $bus_departure->bus->bus_name }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                @isset($bus_departure->bus_route)
                                    {{ $bus_departure->bus_route->source_location->district }} -
                                    {{ $bus_departure->bus_route->destination_location->district }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($bus_departure->departure_datetime)->format('jS, M Y \a\t h:i A') }}
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href={{ route('admin.bus_departure.show', $bus_departure) }}
                                >
                                    View
                                </a>

                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href={{ route('admin.bus_departure.edit', $bus_departure) }}
                                >
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td
                                class="py-4"
                                colspan="4"
                            >
                                No buses departures found.
                            </td>
                        </tr>
                    @endforelse

                    @if (count($bus_departures))
                        <tr>
                            <td
                                class="px-6 py-4 text-center"
                                colspan="4"
                            >
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href="{{ route('admin.bus_departure.index') }}"
                                >
                                    See all bus departures
                                </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-x-10">
            <div>
                <div class="text-lg font-semibold">Buses</div>

                <div class="mt-2 overflow-x-auto rounded-lg border">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Bus Name</th>
                                <th class="px-6 py-3">Total Seats</th>
                                <th class="px-6 py-3">Bus Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($buses as $bus)
                                <tr class="border-b">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $bus->bus_name }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ $bus->total_seats }}
                                    </td>

                                    <td class="px-6 py-4">
                                        {{ ucwords(str_replace('_', ' ', $bus->bus_status)) }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td
                                        class="pt-4"
                                        colspan="3"
                                    >
                                        No buses found.
                                    </td>
                                </tr>
                            @endforelse

                            @if (count($buses))
                                <tr>
                                    <td
                                        class="px-6 py-4 text-center"
                                        colspan="3"
                                    >
                                        <a
                                            class="font-medium text-blue-600 hover:underline"
                                            href="{{ route('admin.bus.index') }}"
                                        >
                                            See all buses
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                <div class="text-lg font-semibold">Bookings</div>

                <div class="mt-2 overflow-x-auto rounded-lg border">
                    <table class="w-full rounded text-left text-sm text-gray-500">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Customer Name</th>
                                <th class="px-6 py-3">Paid Amount</th>
                                <th class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr class="border-b">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        @isset($booking->customer)
                                            {{ $booking->customer->name }}
                                        @else
                                            -
                                        @endisset
                                    </td>

                                    <td class="px-6 py-4">
                                        Rs. {{ number_format($booking->grand_total) }}
                                    </td>

                                    <td class="flex gap-x-2 px-6 py-4">
                                        <a
                                            class="font-medium text-blue-600 hover:underline"
                                            href={{ route('admin.booking.show', $booking) }}
                                        >
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td
                                        class="pt-4"
                                        colspan="3"
                                    >
                                        No bookings found.
                                    </td>
                                </tr>
                            @endforelse

                            @if ($bookings)
                                <tr>
                                    <td
                                        class="px-6 py-4 text-center"
                                        colspan="3"
                                    >
                                        <a
                                            class="font-medium text-blue-600 hover:underline"
                                            href="{{ route('admin.booking.index') }}"
                                        >
                                            See all bookings
                                        </a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
