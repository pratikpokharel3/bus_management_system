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

        <div class="mt-6 overflow-x-auto shadow-md">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="text-gray-70 bg-gray-50 text-xs uppercase">
                    <tr>
                        <th class="px-6 py-3">Customer Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Phone Number</th>
                        <th class="px-6 py-3">Location</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($customers as $customer)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $customer->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->email }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $customer->phone_number ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                @isset($customer->location)
                                    {{ $customer->location->district }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href={{ route('admin.customer.show', $customer) }}
                                >
                                    View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="pt-4 text-center"
                                colspan="5"
                            >
                                No customers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-6">
                {{ $customers->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>
