<x-app-layout>
    <x-card>
        <x-go-back></x-go-back>
        
        <x-page-header>Add New User</x-page-header>

        <form method="POST" action="{{ route('admin.user.store') }}" class="justify-between mt-5">
            @csrf
            <div class="grid grid-cols-3 gap-x-10 gap-y-6">
                <div>
                    <x-input-label for="name">Name</x-input-label>
        
                    <x-text-input 
                        id="name" 
                        name="name" 
                        type="text" 
                        class="mt-1"     
                        :value="old('name')" />
        
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
    
                <div>
                    <x-input-label for="email">Email</x-input-label>
        
                    <x-text-input 
                        id="email" 
                        type="email" 
                        name="email" 
                        class="mt-1" 
                        :value="old('email')" />
        
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-label for="gender">Gender</x-input-label>
        
                    <x-select 
                        id="gender" 
                        class="mt-1" 
                        name="gender"
                        :value="old('gender')"
                    >
                        @foreach (\App\Enums\Gender::cases() as $gender)
                            <option 
                                value="{{ $gender->value }}" 
                                {{ old('gender') === $gender->value ? 'selected' : ''}}
                            >
                                {{ ucwords($gender->value) }}
                            </option>
                        @endforeach
                    </x-select>
        
                    <x-input-error class="mt-2" :messages="$errors->get('gender')" />
                </div>
    
                <div>
                    <x-input-label for="phone_number">Phone Number</x-input-label>
        
                    <x-text-input 
                        type="text" 
                        class="mt-1" 
                        id="phone_number" 
                        name="phone_number" 
                        :value="old('phone_number')" />
        
                    <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
                </div>

                <div>
                    <x-input-label for="location_id">Location</x-input-label>
        
                    <x-select 
                        class="mt-1" 
                        id="location_id" 
                        name="location_id"
                        :value="old('location_id')"
                    >
                        @foreach ($locations as $value)
                            <option 
                                value="{{ $value->id }}" 
                                {{ old('location_id') == $value->id ? 'selected' : ''}}
                            >
                                {{ $value->district }}
                            </option>
                        @endforeach
                    </x-select>

                    <x-input-error class="mt-2" :messages="$errors->get('location_id')" />
                </div>

                <div>
                    <x-input-label for="user_role">User Role</x-input-label>
        
                    <x-select 
                        class="mt-1" 
                        id="user_role"
                        name="user_role"
                    >
                        @foreach (\App\Enums\UserRole::cases() as $user_role)
                            @if ($user_role->value !== 'super_admin' && $user_role->value !== 'customer')
                                <option 
                                    value="{{ $user_role->value }}" 
                                    {{ old('user_role') === $user_role->value ? 'selected' : ''}}
                                >
                                    {{ ucwords($user_role->value) }}
                                </option>
                            @endif
                        @endforeach
                    </x-select>
        
                    <x-input-error class="mt-2" :messages="$errors->get('user_role')" />
                </div>

                <div>
                    <x-input-label for="password">Password</x-input-label>
        
                    <x-text-input 
                        class="mt-1" 
                        id="password" 
                        type="password" 
                        name="password" 
                        :value="old('password')" />
        
                    <x-input-error class="mt-2" :messages="$errors->get('password')" />
                </div>

            </div>

            <div class="mt-10">
                <x-primary-button>Add New User</x-primary-button>
            </div>
        </form>
    </x-card>
</x-app-layout>