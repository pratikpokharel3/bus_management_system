@if (session()->has('success'))
    <div
        class="fixed top-3 flex w-full justify-center"
        x-show="show"
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
    >
        <div class="rounded-xl bg-indigo-800 px-4 py-2 text-sm text-white">{{ session('success') }}</div>
    </div>
@endif
