<div class="relative">
    <div class="absolute inset-y-0 flex items-center pl-3">
        <svg
            class="h-5 w-5 text-gray-500"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            >
            </path>
        </svg>
    </div>

    <input
        type="text"
        {{ $attributes->merge(['class' => 'w-full text-sm rounded-lg border border-gray-300 bg-gray-50 p-3 pl-10']) }}"
    >
</div>
