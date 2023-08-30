<x-app-layout>
    <x-card>
        <x-page-header>Manage Bus Departures</x-page-header>

        <div class="my-4 flex justify-between">
            <div class="w-1/3">
                <form
                    method="GET"
                    action=""
                >
                    <x-search-input
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search bus..."
                    >
                    </x-search-input>
                </form>
            </div>

            <x-button-link href="{{ route('admin.bus_departure.create') }}">Add New Departure</x-button-link>
        </div>

        <div class="mt-6 overflow-x-auto shadow-md">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Bus Name</th>
                        <th class="px-6 py-3">Source-Destination</th>
                        <th class="px-6 py-3">Departure DateTime</th>
                        <th class="px-6 py-3">Departure Status</th>
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
                                {{ ucwords(str_replace('_', ' ', $bus_departure->departure_status)) }}
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href={{ route('admin.bus_departure.show', $bus_departure) }}
                                >
                                    View
                                </a>

                                @php
                                    $departure_status = $bus_departure->departure_status;
                                    $not_started = \App\Enums\BusDepartureStatus::NOT_STARTED->value;
                                    $pending = \App\Enums\BusDepartureStatus::PENDING->value;
                                @endphp

                                @if ($departure_status === $not_started || $departure_status === $pending)
                                    <a
                                        class="font-medium text-blue-600 hover:underline"
                                        href={{ route('admin.bus_departure.edit', $bus_departure) }}
                                    >
                                        Edit
                                    </a>
                                @endif
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

            <div class="p-6">
                {{ $bus_departures->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>
