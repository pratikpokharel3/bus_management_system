<nav class="w-60 shrink-0 bg-indigo-800 px-5 py-12">
    <x-side-navigation-link
        href="{{ route('admin.dashboard') }}"
        route="admin.dashboard"
    >
        Dashboard
    </x-side-navigation-link>

    <x-side-navigation-link
        href="{{ route('admin.bus.index') }}"
        route="admin.bus.*"
    >
        Manage Buses
    </x-side-navigation-link>

    <x-side-navigation-link
        href="{{ route('admin.bus_route.index') }}"
        route="admin.bus_route.*"
    >
        Manage Bus Routes
    </x-side-navigation-link>

    <x-side-navigation-link
        href="{{ route('admin.bus_departure.index') }}"
        route="admin.bus_departure.*"
    >
        Manage Bus Departures
    </x-side-navigation-link>

    <x-side-navigation-link
        href="{{ route('admin.booking.index') }}"
        route="admin.booking.*"
    >
        Manage Bookings
    </x-side-navigation-link>

    <x-side-navigation-link
        href="{{ route('admin.payment.index') }}"
        route="admin.payment.*"
    >
        Manage Payments
    </x-side-navigation-link>

    <x-side-navigation-link
        href="{{ route('admin.customer.index') }}"
        route="admin.customer.*"
    >
        Manage Customers
    </x-side-navigation-link>

    @canany(['superadmin', 'admin'], \App\Models\User::class)
        <x-side-navigation-link
            href="{{ route('admin.user.index') }}"
            route="admin.user.*"
        >
            Manage Users
        </x-side-navigation-link>
    @endcanany

    <x-side-navigation-link
        href="{{ route('admin.enquiry.index') }}"
        route="admin.enquiry.*"
    >
        Manage Enquiries
    </x-side-navigation-link>
</nav>
