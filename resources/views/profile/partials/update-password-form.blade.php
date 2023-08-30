<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

        <p class="mt-1 text-sm text-gray-600">
            Ensure your account is using a long, random password to stay secure.
        </p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <div>
            <x-input-label for="current_password">Current Password</x-input-label>

            <x-text-input 
                class="mt-1" 
                type="password" 
                id="current_password" 
                name="current_password" 
                autocomplete="current-password" />
            
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('current_password')" />
        </div>

        <div>
            <x-input-label for="password">New Password</x-input-label>

            <x-text-input 
                class="mt-1"
                id="password" 
                name="password" 
                type="password"
                autocomplete="new-password" />

            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password')" />
        </div>

        <div>
            <x-input-label for="password_confirmation">Confirm Password</x-input-label>
            
            <x-text-input 
                class="mt-1" 
                type="password"
                id="password_confirmation" 
                autocomplete="new-password"
                name="password_confirmation" />
            
            <x-input-error class="mt-2" :messages="$errors->updatePassword->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Save</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-show="show"
                    x-transition
                    x-data="{ show: true }"
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >
                    Saved
            </p>
            @endif
        </div>
    </form>
</section>
