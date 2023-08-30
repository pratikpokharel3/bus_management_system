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

        <div class="mt-6 overflow-x-auto shadow-md">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Bus Name</th>
                        <th class="px-6 py-3">Bus Route</th>
                        <th class="px-6 py-3">Total Seats</th>
                        <th class="px-6 py-3">Bus Owner</th>
                        <th class="px-6 py-3">Bus Status</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($buses as $bus)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $bus->bus_name }}
                            </td>

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
                                {{ $bus->bus_owner }}
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

                                <a
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
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="pt-4 text-center"
                                colspan="4"
                            >
                                No buses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-6">
                {{ $buses->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>
