@props(['href' => '', 'route' => ''])

<a
    class="flex items-center gap-x-3 py-3"
    href={{ $href }}
>
    <svg
        class="h-4"
        fill="white"
        viewBox="0 0 20 20"
        xmlns="http://www.w3.org/2000/svg"
    >
        <path
            d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"
        >
        </path>
    </svg>
    <span class="{{ request()->routeIs($route) ? 'text-white' : 'text-indigo-300' }} hover:text-white">
        {{ $slot }}
    </span>
</a>
