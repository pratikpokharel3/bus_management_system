<x-guest-layout>
    <div class="grid grid-cols-2 place-items-start items-center pl-32 pt-16">
        <div>
            <span class="text-6xl font-medium">Book Bus Tickets</span>
            <div
                class="mt-3 text-5xl"
                style="color: #afafaf;"
            >
                Easily. Securely.
            </div>

            <x-primary-button
                class="mt-6"
                @click="scrollToPosition('bus-tickets')"
            >
                Book Now
            </x-primary-button>
        </div>

        <img
            src="{{ asset('img1.png') }}"
            alt="Bus Image"
        >
    </div>

    <div class="mt-32 px-32 pb-24">
        <x-card class="mt-3 overflow-x-auto rounded-lg border-l border-r border-t">
            <x-page-header class="text-center">Bus Departures</x-page-header>

            <table class="mt-5 w-full text-left text-sm text-gray-500">
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
                                colspan="4"
                            >
                                No buses departures found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </x-card>

        @include('guest.about-bus')

        @include('guest.about-us')

        @include('guest.contact-us')
    </div>
</x-guest-layout>
