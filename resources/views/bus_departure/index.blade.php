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
                    />
                </form>
            </div>

            <x-button-link href="{{ route('admin.bus_departure.create') }}">Add New Bus Departure</x-button-link>
        </div>

        <div class="relative mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Bus name
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
                            Departure Datetime
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Departure Status
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
                    @forelse ($bus_departures as $bus_departure)
                        <tr class="border-b">
                            <th
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                scope="row"
                            >
                                @isset($bus_departure->bus)
                                    {{ $bus_departure->bus->bus_name }}
                                @else
                                    -
                                @endisset
                            </th>

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
                        <tr>
                            <td
                                class="py-4 text-center"
                                colspan="5"
                            >
                                No bus departures found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($bus_departures->total() > $bus_departures->count())
                <div class="mt-5">
                    {{ $bus_departures->links() }}
                </div>
            @endif
        </div>
    </x-card>
</x-app-layout>
