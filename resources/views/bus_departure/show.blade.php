<x-app-layout>
    <x-card>
        <x-go-back></x-go-back>

        <x-page-header class="mt-3">Bus Departure Information</x-page-header>

        <div class="mt-2 grid grid-cols-3 gap-y-5">
            <div class="flex flex-col">
                <span class="font-semibold">Bus Name</span>
                @isset($bus_departure->bus)
                    {{ $bus_departure->bus->bus_name }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Source-Destination</span>
                @isset($bus_departure->bus_route)
                    {{ $bus_departure->bus_route->source_location->district }} -
                    {{ $bus_departure->bus_route->destination_location->district }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Number of Tickets Booked</span>
                {{ $bus_departure->total_tickets_booked }} out of
                @isset($bus_departure->bus)
                    {{ $bus_departure->bus->total_seats }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Seats Booked</span>
                @if ($bus_departure->seats_booked)
                    {{ implode(', ', explode(',', $bus_departure->seats_booked)) }}
                @else
                    None
                @endif
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Departure DateTime</span>
                {{ \Carbon\Carbon::parse($bus_departure->departure_datetime)->format('jS, M Y \a\t h:i A') }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Status</span>
                {{ ucwords(str_replace('_', ' ', $bus_departure->departure_status)) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Added By</span>
                @isset($bus_departure->user)
                    {{ $bus_departure->user->name }}
                @else
                    -
                @endisset
            </div>
        </div>
    </x-card>
</x-app-layout>
