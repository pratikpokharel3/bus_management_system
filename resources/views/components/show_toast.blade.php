@if (session()->has('success'))
    <div 
        x-show="show"
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        class="fixed w-full top-3 flex justify-center"
    >
        <div class="bg-indigo-800 text-white rounded-xl py-2 px-4 text-sm">{{ session('success') }}</div>
    </div>
@endif
