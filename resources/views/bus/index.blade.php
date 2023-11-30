<x-app-layout>
    <x-card>
        <x-page-header>Manage Buses</x-page-header>

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

            <x-button-link href="{{ route('admin.bus.create') }}">Add New Bus</x-button-link>
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
                            Bus Route
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Total Seats
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Bus Status
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
                    @forelse ($buses as $bus)
                        <tr class="border-b">
                            <th
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                scope="row"
                            >
                                {{ $bus->bus_name }}
                            </th>

                            <td class="px-6 py-4">
                                @isset($bus->bus_route)
                                    {{ $bus->bus_route->source_location->district }} -
                                    {{ $bus->bus_route->destination_location->district }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                {{ $bus->total_seats }}
                            </td>

                            <td class="px-6 py-4">
                                {{ ucwords(str_replace('_', ' ', $bus->bus_status)) }}
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href="{{ route('admin.bus.show', $bus) }}"
                                >
                                    View
                                </a>

                                {{-- <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href="{{ route('admin.bus.edit', $bus) }}"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.bus.destroy', $bus) }}"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="font-medium text-blue-600 hover:underline"
                                        type="submit"
                                    >
                                        Delete
                                    </button>
                                </form> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="py-4 text-center"
                                colspan="5"
                            >
                                No buses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($buses->total() > $buses->count())
                <div class="mt-5">
                    {{ $buses->links() }}
                </div>
            @endif
        </div>
    </x-card>
</x-app-layout>
