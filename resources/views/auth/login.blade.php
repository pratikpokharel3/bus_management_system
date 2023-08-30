<x-guest-layout>
  <div class="flex items-start justify-around px-32 mt-12">
    <img src="{{ asset('img3.jpg') }}" alt="Bus Image" class="w-1/2">

    <x-card class="mx-0 my-0 w-1/3">
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <x-input-label for="email">Email</x-input-label>

                <x-text-input 
                    required 
                    autofocus 
                    id="email" 
                    type="email" 
                    name="email" 
                    autocomplete="username"
                    class="block mt-1 w-full" 
                    :value="old('email')"  />

                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>

            <div class="mt-4">
                <x-input-label for="passowrd">Password</x-input-label>

                <x-text-input 
                    required 
                    id="password" 
                    type="password"
                    name="password"
                    class="block mt-1 w-full"
                    autocomplete="current-password" />

                <x-input-error class="mt-2" :messages="$errors->get('password')" />
            </div>

            <div class="mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input 
                        type="checkbox" 
                        id="remember_me" 
                        name="remember"
                        class="rounded border-gray-300 text-indigo-600" />

                    <span class="ml-2 text-sm text-gray-600">Remember me</span>
                </label>
            </div>

            <div class="mt-4">
                <x-primary-button>Log In</x-primary-button>

                {{-- @if (Route::has('password.request'))
                    <div class="text-center mt-6">
                        <a  
                            href="{{ route('password.request') }}"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" 
                        >
                            Forgot your password?
                        </a>    
                    </div>  
                @endif --}}
            </div>

            <div class="text-center mt-5">
                <a  
                    href="{{ route('register') }}" 
                    class="underline text-sm text-gray-600 rounded-md"
                >
                    Register Account?
                </a>
            </div>
        </form>
    </x-card>
  </div>
</x-guest-layout>
