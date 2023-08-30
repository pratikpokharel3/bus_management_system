<x-app-layout>
    <x-card>
        <x-go-back></x-go-back>

        <x-page-header class="mt-3">Bus Information</x-page-header>

        <div class="mt-2 grid grid-cols-3 gap-y-5">
            <div class="flex flex-col">
                <span class="font-semibold">Bus Name</span>
                {{ $bus->bus_name }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Total Seats</span>
                {{ $bus->total_seats }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Plate Number</span>
                {{ $bus->bus_plate_number }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Driver Name</span>
                {{ $bus->driver_name }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Conductor Name</span>
                {{ $bus->conductor_name }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Owner</span>
                {{ $bus->bus_owner }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Status</span>
                {{ ucwords(str_replace('_', ' ', $bus->bus_status)) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Route</span>
                @isset($bus->bus_route)
                    {{ $bus->bus_route->source_location->district }} -
                    {{ $bus->bus_route->destination_location->district }}
                @else
                    -
                @endisset
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Bus Added By</span>
                @isset($bus->user)
                    {{ $bus->user->name }}
                @else
                    -
                @endisset
            </div>
        </div>
    </x-card>
</x-app-layout>
