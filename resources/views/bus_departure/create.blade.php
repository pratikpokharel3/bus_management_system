<x-app-layout>
    <x-card>
        <div class="flex items-center gap-x-3">
            <x-go-back href="{{ route('admin.bus_departure.index') }}"></x-go-back>
            <x-page-header>Add New Bus Departure</x-page-header>
        </div>

        <form
            class="mt-3"
            method="POST"
            action="{{ route('admin.bus_departure.store') }}"
        >
            @csrf
            <div class="grid grid-cols-3 gap-x-10 gap-y-5">
                <div>
                    <x-input-label for="bus_id">Bus Name</x-input-label>

                    <x-select
                        id="bus_id"
                        name="bus_id"
                        :value="old('bus_id')"
                    >
                        @foreach ($buses as $bus)
                            <option
                                value={{ $bus->id }}
                                {{ old('bus_id') == $bus->id ? 'selected' : '' }}
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
                        :value="old('bus_route_id')"
                    >
                        @foreach ($bus_routes as $bus_route)
                            <option
                                value={{ $bus_route->id }}
                                {{ old('bus_route_id') == $bus_route->id ? 'selected' : '' }}
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
                        :value="old('departure_datetime')"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('departure_datetime')"
                    />
                </div>
            </div>

            <div class="mt-10">
                <x-primary-button>Add New Bus Departure</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
