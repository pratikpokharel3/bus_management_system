<x-app-layout>
    <x-card>
        <x-page-header>Customer Enquiries</x-page-header>

        <div class="my-4 w-1/3">
            <form
                method="GET"
                action=""
            >
                <x-search-input
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search name..."
                />
            </form>
        </div>

        <div class="mt-6 overflow-x-auto shadow-md">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Message</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enquiries as $enquiry)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $enquiry->name }}
                            </td>

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
                                class="pt-4 text-center"
                                colspan="4"
                            >
                                No enquiries found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-6">
                {{ $enquiries->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>
