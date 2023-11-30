<x-app-layout>
    <x-card>
        <x-page-header>Manage Bus Routes</x-page-header>

        <div class="my-4 flex justify-end">
            <x-button-link
                class="py-3"
                href="{{ route('admin.bus_route.create') }}"
            >
                Add New Bus Route
            </x-button-link>
        </div>

        <div class="relative mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
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
                            Price
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Added By
                        </th>
                        {{-- <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Action
                        </th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bus_routes as $bus_route)
                        <tr class="border-b">
                            <th
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                scope="row"
                            >
                                {{ $bus_route->source_location->district }} -
                                {{ $bus_route->destination_location->district }}
                            </th>

                            <td class="px-6 py-4">
                                {{ number_format($bus_route->price) }}
                            </td>

                            <td class="px-6 py-4">
                                @isset($bus_route->user)
                                    {{ $bus_route->user->name }}
                                @else
                                    -
                                @endisset
                            </td>

                            {{-- <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href={{ route('admin.bus_route.edit', $bus_route) }}
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.bus_route.destroy', $bus_route) }}"
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
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="py-4 text-center"
                                colspan="4"
                            >
                                No bus routes found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($bus_routes->total() > $bus_routes->count())
                <div class="mt-5">
                    {{ $bus_routes->links() }}
                </div>
            @endif
        </div>
    </x-card>
</x-app-layout>
