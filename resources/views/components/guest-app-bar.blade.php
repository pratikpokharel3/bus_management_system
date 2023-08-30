<nav x-data="{ open: false }" class="flex justify-between items-center pt-10 px-32">
    <div class="text-2xl font-bold">
        <a href="{{ route('home') }}">Araniko Bus Sewa</a>
    </div>

    @guest
    <div class="flex text-lg gap-x-4">
        <a href="{{ route('login') }}">
            <span>Log In</span>
        </a>
        <a href="{{ route('register') }}">
            <span>Register</span>
        </a>
    </div>
    @endguest
   
    @auth
    <div class="flex items-center ml-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-whitehover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    <div>{{ Auth::user()->name }}</div>

                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                @cannot('customer', \App\Models\User::class)
                <x-dropdown-link :href="route('admin.dashboard')">Dashboard</x-dropdown-link>
                @else
                <x-dropdown-link :href="route('customer.dashboard')">Dashboard</x-dropdown-link>
                @endcannot
                
                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link 
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                        Log Out
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
    @endauth
</nav>