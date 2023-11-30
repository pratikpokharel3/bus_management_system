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

        <div class="relative mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Customer name
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Bus Name
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Source-Destination
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Seats Booked
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Booked Date
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr class="border-b">
                            <th
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                scope="row"
                            >
                                @isset($booking->customer)
                                    {{ $booking->customer->name }}
                                @else
                                    -
                                @endisset
                            </th>

                            <td class="px-6 py-4">
                                @isset($booking->bus_departure->bus)
                                    {{ $booking->bus_departure->bus->bus_name }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                @isset($booking->bus_departure->bus_route)
                                    {{ $booking->bus_departure->bus_route->source_location->district }} -
                                    {{ $booking->bus_departure->bus_route->destination_location->district }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                {{ implode(', ', explode(',', $booking->seats_booked)) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($booking->created_at)->format('jS, M Y \a\t h:i A') }}
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
                        <tr>
                            <td
                                class="py-4 text-center"
                                colspan="5"
                            >
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($bookings->total() > $bookings->count())
                <div class="mt-5">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </x-card>
</x-app-layout>
