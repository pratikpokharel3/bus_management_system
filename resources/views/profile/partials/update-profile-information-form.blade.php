<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

        <p class="mt-1 text-sm text-gray-600">
            Update your account's profile information.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="name">Name</x-input-label>

            <x-text-input
                id="name"  
                required 
                autofocus 
                name="name" 
                type="text"
                class="mt-1" 
                autocomplete="name" 
                :value="old('name', $user->name)" />
            
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email">Email</x-input-label>

            <x-text-input 
                required 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1" 
                autocomplete="username"
                :value="old('email', $user->email)" />

            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        Your email address is unverified.

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif --}}
        </div>

        <div>
            <x-input-label for="phone_number">Phone Number</x-input-label>

            <x-text-input 
                required
                type="text" 
                id="phone_number" 
                name="phone_number" 
                class="mt-1" 
                :value="old('phone_number', $user->phone_number)" />

            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <div>
            <x-input-label for="gender">Gender</x-input-label>

            <x-select
                id="gender"
                class="mt-1" 
                name="gender" 
                :value="old('gender', $user->gender)"
            >
                @foreach (\App\Enums\Gender::cases() as $gender)
                    <option 
                        value="{{ $gender->value }}" 
                        {{ old('gender', $user->gender) === $gender->value ? 'selected' : ''}}
                    >
                        {{ ucwords($gender->value) }}
                    </option>
                @endforeach
            </x-select>

            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div>
            <x-input-label for="location_id">Location</x-input-label>

            <x-select
                class="mt-1" 
                id="location_id" 
                name="location_id"
                :value="old('location_id', $user->location_id)"
            >
                @foreach ($locations as $location)
                    <option 
                        value="{{ $location->id }}" 
                        {{ old('location_id', $user->location_id) === $location->id ? 'selected' : ''}}
                    >
                        {{ $location->district }}
                    </option>
                @endforeach
            </x-select>

            <x-input-error class="mt-2" :messages="$errors->get('location_id')" />
        </div>

        <x-primary-button>Update Profile Information</x-primary-button>
    </form>
</section>
