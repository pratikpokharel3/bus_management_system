<x-app-layout>
    <x-card>
        <div class="flex items-center gap-x-3">
            <x-go-back href="{{ route('admin.user.index') }}"></x-go-back>
            <x-page-header>Add New User</x-page-header>
        </div>

        <form
            class="mt-3"
            method="POST"
            action="{{ route('admin.user.store') }}"
        >
            @csrf
            <div class="grid grid-cols-3 gap-x-10 gap-y-5">
                <div>
                    <x-input-label for="name">Name</x-input-label>

                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        :value="old('name')"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('name')"
                    />
                </div>

                <div>
                    <x-input-label for="email">Email</x-input-label>

                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('email')"
                    />
                </div>

                <div>
                    <x-input-label for="gender">Gender</x-input-label>

                    <x-select
                        id="gender"
                        name="gender"
                        :value="old('gender')"
                    >
                        @foreach (\App\Enums\Gender::cases() as $gender)
                            <option
                                value="{{ $gender->value }}"
                                {{ old('gender') === $gender->value ? 'selected' : '' }}
                            >
                                {{ ucwords($gender->value) }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('gender')"
                    />
                </div>

                <div>
                    <x-input-label for="phone_number">Phone Number</x-input-label>

                    <x-text-input
                        id="phone_number"
                        name="phone_number"
                        type="text"
                        :value="old('phone_number')"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('phone_number')"
                    />
                </div>

                <div>
                    <x-input-label for="location_id">Location</x-input-label>

                    <x-select
                        id="location_id"
                        name="location_id"
                        :value="old('location_id')"
                    >
                        @foreach ($locations as $value)
                            <option
                                value="{{ $value->id }}"
                                {{ old('location_id') == $value->id ? 'selected' : '' }}
                            >
                                {{ $value->district }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('location_id')"
                    />
                </div>

                @php
                    $isSuperAdmin = \App\Enums\UserRole::SUPER_ADMIN->value;
                    $isCustomer = \App\Enums\UserRole::CUSTOMER->value;
                @endphp

                <div>
                    <x-input-label for="user_role">User Role</x-input-label>

                    <x-select
                        id="user_role"
                        name="user_role"
                    >
                        @foreach (\App\Enums\UserRole::cases() as $user_role)
                            @if ($user_role->value !== $isSuperAdmin && $user_role->value !== $isCustomer)
                                <option
                                    value="{{ $user_role->value }}"
                                    {{ old('user_role') === $user_role->value ? 'selected' : '' }}
                                >
                                    {{ ucwords($user_role->value) }}
                                </option>
                            @endif
                        @endforeach
                    </x-select>

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('user_role')"
                    />
                </div>

                <div>
                    <x-input-label for="password">Password</x-input-label>

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        :value="old('password')"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('password')"
                    />
                </div>

            </div>

            <div class="mt-10">
                <x-primary-button>Add New User</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>
