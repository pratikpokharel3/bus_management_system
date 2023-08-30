<x-app-layout>
    <x-card>
        <x-go-back></x-go-back>

        <x-page-header class="mt-3">User Information</x-page-header>

        <div class="grid grid-cols-3 gap-y-5 mt-2 pb-5">
            <div class="flex flex-col">
                <span class="font-semibold">Name</span>
                {{ $user->name }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Email</span>
                {{ $user->email }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Gender</span>
                {{ ucwords($user->gender) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Phone Number</span>
                {{ $user->phone_number }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Location</span>
                {{ $user->location->district }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">User Role</span>
                {{ ucwords($user->user_role) }}
            </div>

            <div class="flex flex-col">
                <span class="font-semibold">Account Created At:</span>
                {{ \Carbon\Carbon::parse($user->created_at)->format('jS, M Y \a\t h:i A') }}
            </div>
        </div>

        @if(auth()->user()->user_role === \App\Enums\UserRole::ADMIN->value && $user->user_role ===
        \App\Enums\UserRole::ADMIN->value)
        <x-alert variant="info" class="mt-5">
            Since, this user is also an admin, only super admin is able to change the user role of this user.
        </x-alert>
        @else
        <hr>
        <form method="POST" action="{{ route('admin.user.update', $user) }}">
            @csrf
            @method('PATCH')
            <div class="w-1/3 mt-5">
                <x-input-label for="user_role" class="text-lg font-semibold">
                    Change User Role
                </x-input-label>

                <input type="hidden" name="user_id" value="{{ $user->id }}" />

                <x-select class="mt-1" id="user_role" name="user_role" :value="old('user_role', $user->user_role)">
                    @foreach (\App\Enums\UserRole::cases() as $user_role)
                    @if ($user_role->value !== 'super_admin' && $user_role->value !== 'customer' && $user_role->value
                    !== $user->user_role)
                    <option value="{{ $user_role->value }}" {{ old('user_role', $user->user_role) == $user_role->value ?
                        'selected' : '' }}
                        >
                        {{ ucwords(str_replace('_', ' ', $user_role->value)) }}
                    </option>
                    @endif
                    @endforeach
                </x-select>

                <x-input-error class="mt-2" :messages="$errors->get('user_role')" />
            </div>

            <div class="w-1/3 mt-5">
                <x-primary-button>Change Role</x-primary-button>
            </div>
        </form>
        @endif
    </x-card>
</x-app-layout>