<x-app-layout>
    <x-card>
        <x-page-header>Manage Customers</x-page-header>

        <div class="my-4 w-1/3">
            <form
                method="GET"
                action=""
            >
                <x-search-input
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search customer..."
                />
            </form>
        </div>

        <div class="relative mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Customer name
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Email
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Phone Number
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Location
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
                    @forelse ($customers as $customer)
                        <tr class="border-b">
                            <th
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                scope="row"
                            >
                                {{ $customer->name }}
                            </th>

                            <td class="px-6 py-4">
                                {{ $customer->email }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->phone_number }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->location->district }}
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href="{{ route('admin.customer.show', $customer) }}"
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="py-4 text-center"
                                colspan="5"
                            >
                                No customers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($customers->total() > $customers->count())
                <div class="mt-5">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </x-card>
</x-app-layout>
