<x-guest-layout>
    <div class="flex items-start justify-around px-32 my-12">
        <img src="{{ asset('img3.jpg') }}" alt="Bus Image" class="w-1/2">
    
        <x-card class="mx-0 my-0 w-1/3">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div>
                    <x-input-label for="name">Name</x-input-label>

                    <x-text-input
                        required 
                        id="name" 
                        type="text" 
                        name="name" 
                        class="mt-1"
                        :value="old('name')" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email">Email</x-input-label>

                    <x-text-input
                        required  
                        id="email"
                        type="email" 
                        name="email"  
                        class="mt-1" 
                        :value="old('email')" />
                    
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password">Password</x-input-label>

                    <x-text-input
                        required  
                        class="mt-1"
                        id="password" 
                        type="password"
                        name="password"
                        autocomplete="new-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password_confirmation">Confirm Password</x-input-label>

                    <x-text-input 
                        required
                        class="mt-1"
                        type="password"
                        id="password_confirmation" 
                        autocomplete="new-password"
                        name="password_confirmation" />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-primary-button>Register</x-primary-button>
                </div>

                <div class="text-center mt-5">
                    <a  
                        href="{{ route('login') }}" 
                        class="underline text-sm text-gray-600 rounded-md"
                    >
                        Already registered?
                    </a>
                </div>
            </form>
        </x-card>
    </div>
</x-guest-layout>
