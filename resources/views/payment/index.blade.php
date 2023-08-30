<x-app-layout>
    <x-card>
        <x-page-header>Manage Payments</x-page-header>

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
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Customer Name</th>
                        <th class="px-6 py-3">Amount</th>
                        <th class="px-6 py-3">Paid Date</th>
                        <th class="px-6 py-3">Booking Status</th>
                        <th class="px-6 py-3">Payment Status</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $payment)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                @isset($payment->customer)
                                    {{ $payment->customer->name }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                Rs. {{ number_format($payment->paid_amount) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($payment->created_at)->format('jS, M Y \a\t h:i A') }}
                            </td>

                            <td class="px-6 py-4">
                                @isset($payment->booking)
                                    {{ ucwords($payment->booking->booking_status) }}
                                @else
                                    -
                                @endisset
                            </td>

                            <td class="px-6 py-4">
                                {{ ucwords(str_replace('_', ' ', $payment->payment_status)) }}
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href={{ route('admin.booking.show', $payment->booking_id) }}
                                >
                                    View Booking
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="pt-4 text-center"
                                colspan="5"
                            >
                                No payments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-6">
                {{ $payments->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>
