<nav
    class="border-b border-gray-100 bg-white"
    x-data="{ open: false }"
>
    <div class="mx-auto max-w-7xl px-8">
        <div class="flex h-16 items-center justify-between">
            <a
                class="flex items-center gap-x-2"
                href="{{ route('admin.dashboard') }}"
            >
                <img
                    class="h-6 w-6"
                    src="{{ asset('bus.svg') }}"
                    alt="Bus Logo"
                >
                <span class="text-xl font-semibold">Araniko Bus Sewa</span>
            </a>

            @auth
                <x-dropdown
                    align="right"
                    width="48"
                >
                    <x-slot name="trigger">
                        <button
                            class="bg-whitehover:text-gray-700 inline-flex items-center rounded-md border border-transparent px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out focus:outline-none"
                        >
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg
                                    class="h-4 w-4 fill-current"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form
                            method="POST"
                            action="{{ route('logout') }}"
                        >
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
            @endauth
        </div>
    </div>
</nav>
