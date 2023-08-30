<x-app-layout>
    <x-card>
        <x-page-header>Dashboard</x-page-header>

        <x-card class="mx-0 mt-2">
            <x-page-header class="text-xl">Bus Departures</x-page-header>

            <table class="mt-2 w-full text-left text-sm text-gray-500">
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
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($bus_departure->departure_datetime)->format('jS, M Y \a\t h:i A') }}
                            </td>

                            <td class="px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href="{{ route('customer.booking.create', $bus_departure) }}"
                                >
                                    Book Now
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td
                                class="pt-4"
                                colspan="3"
                            >
                                No buses departures found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>
    </x-card>
</x-app-layout>
