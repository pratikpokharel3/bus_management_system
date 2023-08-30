<x-app-layout>
    <x-card>
        <x-page-header>Manage Bookings</x-page-header>

        <div class="my-4 w-1/3">
            <form
                method="GET"
                action=""
            >
                <x-search-input
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search customer..."
                />
            </form>
        </div>

        <div class="mt-6 overflow-x-auto shadow-md">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Customer Name</th>
                        <th class="px-6 py-3">Source-Destination</th>
                        <th class="px-6 py-3">Booked Date</th>
                        <th class="px-6 py-3">Booking Status</th>
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

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($booking->created_at)->format('jS, M Y \a\t h:i A') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ ucwords($booking->booking_status) }}
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
                                colspan="5"
                            >
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-6">
                {{ $bookings->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>
