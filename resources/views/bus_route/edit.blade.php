<x-app-layout>
    <x-card>
        <x-go-back></x-go-back>

        <x-page-header>Edit Bus Route</x-page-header>

        <form
            class="mt-5 justify-between"
            method="POST"
            action="{{ route('admin.bus_route.update', $bus_route) }}"
        >
            @csrf
            @method('PATCH')
            <div class="grid grid-cols-3 gap-x-10 gap-y-6">
                <div>
                    <x-input-label for="source_location_id">Source Location</x-input-label>

                    <x-select
                        class="mt-1"
                        id="source_location_id"
                        name="source_location_id"
                        :value="old('source_location_id', $bus_route->source_location_id)"
                    >
                        @foreach ($locations as $location)
                            <option
                                value={{ $location->id }}
                                {{ old('source_location_id', $bus_route->source_location_id) == $location->id ? 'selected' : '' }}
                            >
                                {{ $location->district }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('source_location_id')"
                    />
                </div>

                <div>
                    <x-input-label for="destination_location_id">Destination Location</x-input-label>

                    <x-select
                        class="mt-1"
                        id="destination_location_id"
                        name="destination_location_id"
                        :value="old('destination_location_id', $bus_route->destination_location_id)"
                    >
                        @foreach ($locations as $location)
                            <option
                                value={{ $location->id }}
                                {{ old('destination_location_id', $bus_route->destination_location_id) == $location->id ? 'selected' : '' }}
                            >
                                {{ $location->district }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('destination_location_id')"
                    />
                </div>

                <div>
                    <x-input-label for="price">Ticket Price (Per 1 Person)</x-input-label>

                    <x-text-input
                        class="mt-1"
                        id="price"
                        name="price"
                        type="text"
                        :value="old('price', $bus_route->price)"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('price')"
                    />
                </div>
            </div>

            <div class="mt-10">
                <x-primary-button>Update Route Information</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
