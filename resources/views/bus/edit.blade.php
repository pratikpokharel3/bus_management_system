<x-app-layout>
    <x-card>
        <div class="flex items-center gap-x-3">
            <x-go-back href="{{ route('admin.bus.index') }}"></x-go-back>
            <x-page-header>Edit Bus Information</x-page-header>
        </div>

        <form
            class="mt-3 justify-between"
            method="POST"
            action="{{ route('admin.bus.update', $bus) }}"
        >
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-3 gap-x-10 gap-y-5">
                <div>
                    <x-input-label for="bus_name">Bus Name</x-input-label>

                    <x-text-input
                        id="bus_name"
                        name="bus_name"
                        type="text"
                        :value="old('bus_name', $bus->bus_name)"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('bus_name')"
                    />
                </div>

                <div>
                    <x-input-label for="total_seats">Total Seats</x-input-label>

                    <x-text-input
                        id="total_seats"
                        name="total_seats"
                        type="text"
                        disabled
                        :value="old('total_seats', $bus->total_seats)"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('total_seats')"
                    />
                </div>

                <div>
                    <x-input-label for="bus_plate_number">Bus Plate Number</x-input-label>

                    <x-text-input
                        id="bus_plate_number"
                        name="bus_plate_number"
                        type="text"
                        :value="old('bus_plate_number', $bus->bus_plate_number)"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('bus_plate_number')"
                    />
                </div>

                <div>
                    <x-input-label for="driver_name">Driver Name</x-input-label>

                    <x-text-input
                        id="driver_name"
                        name="driver_name"
                        type="text"
                        :value="old('driver_name', $bus->driver_name)"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('driver_name')"
                    />
                </div>

                <div>
                    <x-input-label for="conductor_name">Conductor Name</x-input-label>

                    <x-text-input
                        id="conductor_name"
                        name="conductor_name"
                        type="text"
                        :value="old('conductor_name', $bus->conductor_name)"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('conductor_name')"
                    />
                </div>

                <div>
                    <x-input-label for="bus_owner">Bus Owner</x-input-label>

                    <x-text-input
                        id="bus_owner"
                        name="bus_owner"
                        type="text"
                        :value="old('bus_owner', $bus->bus_owner)"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('bus_owner')"
                    />
                </div>

                <div>
                    <x-input-label for="bus_status">Bus Status</x-input-label>

                    <x-select
                        id="bus_status"
                        name="bus_status"
                        :value="old('bus_status', $bus->bus_status)"
                    >
                        @foreach (\App\Enums\BusStatus::cases() as $bus_status)
                            <option
                                value="{{ $bus_status->value }}"
                                {{ old('bus_status', $bus->bus_status) == $bus_status->value ? 'selected' : '' }}
                            >
                                {{ ucwords(str_replace('_', ' ', $bus_status->value)) }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('bus_status')"
                    />
                </div>

                <div>
                    <x-input-label for="bus_route_id">Bus Route</x-input-label>

                    <x-select
                        id="bus_route_id"
                        name="bus_route_id"
                        disabled
                        :value="old('bus_route_id', $bus->bus_route_id)"
                    >
                        @foreach ($bus_routes as $bus_route)
                            <option
                                value="{{ $bus_route->id }}"
                                {{ old('bus_route_id', $bus->bus_route_id) == $bus_route->id ? 'selected' : '' }}
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
            </div>

            <div class="mt-10">
                <x-primary-button>Update Bus Information</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
