<x-app-layout>
    <x-card>
        <x-page-header>Dashboard</x-page-header>

        <div class="mt-3 grid grid-cols-5 gap-x-6 gap-y-5">
            <div
                class="flex h-32 flex-col justify-between rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 pb-2 pt-3 font-semibold text-white shadow-md">
                <span class="text-4xl">{{ $total_buses }}</span>
                <div>
                    <div class="mb-1">Total Buses</div>
                    <a
                        class="inline-flex gap-x-1 text-sm underline"
                        href="{{ route('admin.bus.index') }}"
                    >
                        View <x-icons.arrow-right-thin class="text-white" />
                    </a>
                </div>
            </div>

            <div
                class="flex h-32 flex-col justify-between rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 pb-2 pt-3 font-semibold text-white shadow-md">
                <span class="text-4xl">{{ $total_bus_routes }}</span>
                <div>
                    <div class="mb-1">Total Bus Routes</div>
                    <a
                        class="inline-flex gap-x-1 text-sm underline"
                        href="{{ route('admin.bus_route.index') }}"
                    >
                        View <x-icons.arrow-right-thin class="text-white" />
                    </a>
                </div>
            </div>

            <div
                class="flex h-32 flex-col justify-between rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 pb-2 pt-3 font-semibold text-white shadow-md">
                <span class="text-4xl">{{ $total_bus_departures }}</span>
                <div>
                    <div class="mb-1">Total Bus Departures</div>
                    <a
                        class="inline-flex gap-x-1 text-sm underline"
                        href="{{ route('admin.bus_departure.index') }}"
                    >
                        View <x-icons.arrow-right-thin class="text-white" />
                    </a>
                </div>
            </div>

            <div
                class="flex h-32 flex-col justify-between rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 pb-2 pt-3 font-semibold text-white shadow-md">
                <span class="text-4xl">{{ $total_bookings }}</span>
                <div>
                    <div class="mb-1">Total Bookings</div>
                    <a
                        class="inline-flex gap-x-1 text-sm underline"
                        href="{{ route('admin.booking.index') }}"
                    >
                        View <x-icons.arrow-right-thin class="text-white" />
                    </a>
                </div>
            </div>

            <div
                class="flex h-32 flex-col justify-between rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 pb-2 pt-3 font-semibold text-white shadow-md">
                <span class="text-4xl">{{ $total_payments }}</span>
                <div>
                    <div class="mb-1">Total Payments</div>
                    <a
                        class="inline-flex gap-x-1 text-sm underline"
                        href="{{ route('admin.payment.index') }}"
                    >
                        View <x-icons.arrow-right-thin class="text-white" />
                    </a>
                </div>
            </div>

            <div
                class="flex h-32 flex-col justify-between rounded-lg bg-gradient-to-r from-cyan-500 to-blue-500 px-3 pb-2 pt-3 font-semibold text-white shadow-md">
                <span class="text-4xl">{{ $total_customers }}</span>
                <div>
                    <div class="mb-1">Total Customers</div>
                    <a
                        class="inline-flex gap-x-1 text-sm underline"
                        href="{{ route('admin.customer.index') }}"
                    >
                        View <x-icons.arrow-right-thin class="text-white" />
                    </a>
                </div>
            </div>
        </div>
    </x-card>
</x-app-layout>
