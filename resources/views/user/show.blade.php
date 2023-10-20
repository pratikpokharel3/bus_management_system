<x-app-layout>
    <x-card>
        <div class="flex items-center gap-x-3">
            <x-go-back href="{{ route('admin.user.index') }}"></x-go-back>
            <x-page-header>User Information</x-page-header>
        </div>

        <div class="mt-2 grid grid-cols-3 gap-y-5">
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

        @php
            $isSuperAdmin = \App\Enums\UserRole::SUPER_ADMIN->value;
            $isAdmin = \App\Enums\UserRole::ADMIN->value;
            $isStaff = \App\Enums\UserRole::STAFF->value;
            $currentUserRole = auth()->user()->user_role;

            $user_roles = [$isAdmin, $isStaff];
        @endphp

        @if ($currentUserRole === $user->user_role)
            <x-alert
                class="mt-6"
                variant="info"
            >
                Since, {{ $user->name }} is also an admin, only super admin can change the user role of this user.
            </x-alert>
        @endif

        @if ($currentUserRole === $isSuperAdmin || ($currentUserRole === $isAdmin && $user->user_role === $isStaff))
            <hr class="mt-5">
            <form
                method="POST"
                action="{{ route('admin.user.update', $user) }}"
            >
                @csrf
                @method('PATCH')
                <div class="mt-5 w-1/3">
                    <x-input-label for="user_role">Change User Role</x-input-label>

                    <x-select
                        id="user_role"
                        name="user_role"
                        :value="old('user_role', $user->user_role)"
                    >
                        @foreach ($user_roles as $user_role)
                            <option
                                value="{{ $user_role }}"
                                {{ old('user_role', $user->user_role) == $user_role ? 'selected' : '' }}
                            >
                                {{ ucwords(str_replace('_', ' ', $user_role)) }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('user_role')"
                    />
                </div>

                <div class="mt-5 w-1/3">
                    <x-primary-button>Change Role</x-primary-button>
                </div>
            </form>
        @endif
    </x-card>
</x-app-layout>
