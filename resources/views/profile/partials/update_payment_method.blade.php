<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Update Payment Method</h2>

        <p class="mt-1 text-sm text-gray-600">
            Change bank information for online payment for bookings.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.update_bank_information') }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="bank_id">Select Bank</x-input-label>

            <x-select
                class="mt-1"
                id="bank_id"
                name="bank_id"
                :value="old('bank_id', $user_bank_info->bank_id ?? '')"
            >
                @foreach ($banks as $bank)
                    <option 
                        value="{{ $bank->id }}" 
                        {{ old('bank_id', $user_bank_info->bank_id ?? '') === $bank->id ? 'selected' : ''}}
                    >
                        {{ $bank->bank_name }}
                    </option>
                @endforeach
            </x-select>
            
            <x-input-error class="mt-2" :messages="$errors->get('bank_id')" />
        </div>

        <div>
            <x-input-label for="account_number">Account Number</x-input-label>

            <x-text-input 
                type="text" 
                class="mt-1"
                id="account_number" 
                name="account_number"
                :value="old('account_number', $user_bank_info->account_number ?? '')" />

            <x-input-error class="mt-2" :messages="$errors->get('account_number')" />
        </div>

        <x-primary-button>Update Bank Information</x-primary-button>
    </form>
</section>
