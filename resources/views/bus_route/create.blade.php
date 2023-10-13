<x-app-layout>
    <x-card>
        <x-page-header>Add New Route</x-page-header>

        <form
            class="mt-3"
            method="POST"
            action="{{ route('admin.bus_route.store') }}"
        >
            @csrf
            <div class="grid grid-cols-3 gap-x-10 gap-y-5">
                <div>
                    <x-input-label for="source_location_id">Source Location</x-input-label>

                    <x-select
                        id="source_location_id"
                        name="source_location_id"
                        :value="old('source_location_id')"
                    >
                        @foreach ($locations as $location)
                            <option
                                value={{ $location->id }}
                                {{ old('source_location_id') == $location->id ? 'selected' : '' }}
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
                        id="destination_location_id"
                        name="destination_location_id"
                        :value="old('destination_location_id')"
                    >
                        @foreach ($locations as $location)
                            <option
                                value={{ $location->id }}
                                {{ old('destination_location_id') == $location->id ? 'selected' : '' }}
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
                        id="price"
                        name="price"
                        type="text"
                        :value="old('price')"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('price')"
                    />
                </div>
            </div>

            <div class="mt-10">
                <x-primary-button>Add New Route</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
