<x-guest-layout>
    <div class="flex w-4/5 grow items-center justify-between self-center">
        <img
            class="w-1/2"
            src="{{ asset('img3.jpg') }}"
        >

        <x-card class="mx-0 my-0 !w-1/3">
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
