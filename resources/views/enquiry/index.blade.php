<x-app-layout>
    <x-card>
        <x-page-header>Manage Enquiries</x-page-header>

        <div class="my-4 w-1/3">
            <form
                method="GET"
                action=""
            >
                <x-search-input
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search customer..."
                />
            </form>
        </div>

        <div class="relative mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Name
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Email
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Message
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enquiries as $enquiry)
                        <tr class="border-b">
                            <th
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                scope="row"
                            >
                                {{ $enquiry->name }}
                            </th>

                            <td class="px-6 py-4">
                                {{ $enquiry->email }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $enquiry->message }}
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <form
                                    method="POST"
                                    action="{{ route('admin.enquiry.destroy', $enquiry) }}"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        class="font-medium text-blue-600 hover:underline"
                                        type="submit"
                                    >
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                class="py-4 text-center"
                                colspan="4"
                            >
                                No customer enquires found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($enquiries->total() > $enquiries->count())
                <div class="mt-5">
                    {{ $enquiries->links() }}
                </div>
            @endif
        </div>
    </x-card>
</x-app-layout>
