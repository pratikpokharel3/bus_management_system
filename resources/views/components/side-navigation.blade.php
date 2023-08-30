<nav class="w-60 shrink-0 bg-indigo-800 px-5 py-12 text-white">
    @canany(['superadmin', 'admin', 'staff'], \App\Models\User::class)
        <x-side-navigation-link
            href="{{ route('admin.dashboard') }}"
            content="Dashboard"
        />

        <x-side-navigation-link
            href="{{ route('admin.bus.index') }}"
            content="Manage Buses"
        />

        <x-side-navigation-link
            href="{{ route('admin.bus_route.index') }}"
            content="Manage Bus Routes"
        />

        <x-side-navigation-link
            href="{{ route('admin.bus_departure.index') }}"
            content="Manage Bus Departures"
        />

        <x-side-navigation-link
            href="{{ route('admin.booking.index') }}"
            content="Manage Bookings"
        />

        <x-side-navigation-link
            href="{{ route('admin.payment.index') }}"
            content="Manage Payments"
        />

        <x-side-navigation-link
            href="{{ route('admin.customer.index') }}"
            content="Manage Customers"
        />
    @endcanany

    @canany(['superadmin', 'admin'], \App\Models\User::class)
        <x-side-navigation-link
            href="{{ route('admin.user.index') }}"
            content="Manage Users"
        />
    @endcanany

    @canany(['superadmin', 'admin', 'staff'], \App\Models\User::class)
        <x-side-navigation-link
            href="{{ route('admin.enquiry.index') }}"
            content="Manage Enquiries"
        />
    @endcanany

    @can(['customer'], \App\Models\User::class)
        <x-side-navigation-link
            href="{{ route('customer.dashboard') }}"
            content="Dashboard"
        />

        <x-side-navigation-link
            href="{{ route('customer.booking.index') }}"
            content="My Bookings"
        />

        <x-side-navigation-link
            href="{{ route('customer.payment.index') }}"
            content="My Payments"
        />
    @endcan
</nav>
