<x-guest-layout>
    <div class="flex w-1/4 grow items-center self-center">
        <x-card class="mx-0 my-0">
            <form
                method="POST"
                action="{{ route('login') }}"
            >
                @csrf
                <div>
                    <x-input-label for="email">Email</x-input-label>

                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autocomplete="email"
                        :value="old('email')"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('email')"
                    />
                </div>

                <div class="mt-4">
                    <x-input-label for="passowrd">Password</x-input-label>

                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                    />

                    <x-input-error
                        class="mt-2"
                        :messages="$errors->get('password')"
                    />
                </div>

                <div class="mt-5">
                    <x-primary-button>Log In</x-primary-button>
                </div>
            </form>
        </x-card>
    </div>
</x-guest-layout>
