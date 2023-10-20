<x-app-layout>
    <x-card>
        <div class="flex items-center gap-x-3">
            <x-go-back href="{{ route('admin.bus_departure.index') }}"></x-go-back>
            <x-page-header>Edit Bus Departure</x-page-header>
        </div>

        @php
            $departure_status = [];

            $not_started = \App\Enums\BusDepartureStatus::NOT_STARTED->value;
            $pending = \App\Enums\BusDepartureStatus::PENDING->value;
            $arrived = \App\Enums\BusDepartureStatus::ARRIVED->value;
            $cancelled = \App\Enums\BusDepartureStatus::CANCELLED->value;

            if ($bus_departure->departure_status === $not_started) {
                $departure_status[] = $not_started;
                $departure_status[] = $pending;
                $departure_status[] = $cancelled;
            } elseif ($bus_departure->departure_status === $pending) {
                $departure_status[] = $arrived;
            }
        @endphp

        <form
            class="mt-3"
            method="POST"
            action="{{ route('admin.bus_departure.update', $bus_departure) }}"
        >
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-3 gap-x-10 gap-y-5">
                <div>
                    <x-input-label for="bus_id">Bus Name</x-input-label>

                    <x-select
                        id="bus_id"
                        name="bus_id"
                        :disabled="$bus_departure->departure_status !== $not_started"
                        :value="old('bus_id', $bus_departure->bus->id)"
                    >
                        @foreach ($buses as $bus)
                            <option
                                value={{ $bus->id }}
                                {{ old('bus_id', $bus_departure->bus->id) == $bus->id ? 'selected' : '' }}
                            >
                                {{ $bus->bus_name }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('bus_id')"
                    />
                </div>

                <div>
                    <x-input-label for="bus_route_id">Source-Destination</x-input-label>

                    <x-select
                        id="bus_route_id"
                        name="bus_route_id"
                        :disabled="$bus_departure->departure_status !== $not_started"
                        :value="old('bus_route_id', $bus_departure->bus_route_id)"
                    >
                        @foreach ($bus_routes as $bus_route)
                            <option
                                value={{ $bus_route->id }}
                                {{ old('bus_route_id', $bus_departure->bus_route_id) == $bus_route->id ? 'selected' : '' }}
                            >
                                {{ $bus_route->source_location->district }} -
                                {{ $bus_route->destination_location->district }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('bus_route_id')"
                    />
                </div>

                <div>
                    <x-input-label for="departure_datetime">Departure DateTime</x-input-label>

                    <x-text-input
                        id="departure_datetime"
                        name="departure_datetime"
                        type="datetime-local"
                        min="{{ now()->format('Y-m-d\TH:i') }}"
                        :disabled="$bus_departure->departure_status !== $not_started"
                        :value="old(
                            'departure_datetime',
                            \Carbon\Carbon::parse($bus_departure->departure_datetime)->format('Y-m-d\TH:i'),
                        )"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('departure_datetime')"
                    />
                </div>

                <div>
                    <x-input-label for="status">Departure Status</x-input-label>

                    <x-select
                        id="status"
                        name="status"
                        disabled
                        :value="$bus_departure->departure_status"
                    >
                        @foreach (\App\Enums\BusDepartureStatus::cases() as $status)
                            <option
                                value="{{ $status->value }}"
                                {{ $bus_departure->departure_status === $status->value ? 'selected' : '' }}
                            >
                                {{ ucwords(str_replace('_', ' ', $status->value)) }}
                            </option>
                        @endforeach
                    </x-select>
                </div>
            </div>

            @if ($bus_departure->departure_status === $not_started || $bus_departure->departure_status === $pending)
                <div class="mt-6 grid grid-cols-3 gap-x-10 gap-y-6 border-t pt-4">
                    <div>
                        <x-input-label for="departure_status">
                            Change Departure Status
                        </x-input-label>

                        <x-select
                            id="departure_status"
                            name="departure_status"
                            :value="old('departure_status', $bus_departure->departure_status)"
                        >
                            @foreach ($departure_status as $status)
                                <option
                                    value="{{ $status }}"
                                    {{ old('departure_status', $bus_departure->departure_status) === $status ? 'selected' : '' }}
                                >
                                    {{ ucwords(str_replace('_', ' ', $status)) }}
                                </option>
                            @endforeach
                        </x-select>

                        <x-input-error
                            class="mt-2"
                            :messages="$errors->get('departure_status')"
                        />
                    </div>
                </div>

                <div class="mt-10">
                    <x-primary-button>Update Bus Departure</x-primary-button>
                </div>
            @endif
        </form>
    </x-card>
</x-app-layout>
