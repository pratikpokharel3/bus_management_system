<div class="mx-auto mb-5 mt-32 w-1/2">
    <x-page-header
        class="flex flex-col items-center"
        id="contact-us"
    >
        <span>Contact Us</span>
        <div
            class="mt-4 border-b-4 border-b-blue-800"
            style="width: 8%"
        ></div>
    </x-page-header>

    <script>
        const errors = <?php echo $errors; ?>;

        if (errors.length !== 0) {
            setTimeout(() => {
                useScrollToPosition('contact-us');
            }, 100);
        }

        function useScrollToPosition(id) {
            const el = document.getElementById(id);

            if (el !== null) {
                const topPosition = el.offsetTop - 20;
                window.scrollTo({
                    top: topPosition,
                    behavior: "smooth"
                });
            }
        }
    </script>

    <form
        method="POST"
        action="{{ route('customer_enquiries') }}"
    >
        @csrf
        <div>
            <x-input-label for="name">Name</x-input-label>

            <x-text-input
                class="mt-1"
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

        <div class="mt-4">
            <x-input-label for="email">Email</x-input-label>

            <x-text-input
                class="mt-1"
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

        <div class="mt-4">
            <x-input-label for="message">Message</x-input-label>

            <x-textarea
                class="mt-1"
                id="message"
                name="message"
                rows="4"
                placeholder="Enter your message here..."
                :value="old('message')"
            >
            </x-textarea>

            <x-input-error
                class="mt-2"
                :messages="$errors->get('message')"
            />
        </div>

        <x-primary-button class="mt-6">
            Send
        </x-primary-button>
    </form>
</div>
