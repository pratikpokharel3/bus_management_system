<x-app-layout>
    <x-card>
        <x-page-header>Manage Users</x-page-header>

        <div class="my-4 flex justify-between">
            <div class="w-1/3">
                <form
                    method="GET"
                    action=""
                >
                    <x-search-input
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search user..."
                    />
                </form>
            </div>

            <x-button-link href="{{ route('admin.user.create') }}">Add New User</x-button-link>
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
                            Phone Number
                        </th>
                        <th
                            class="px-6 py-3"
                            scope="col"
                        >
                            User Role
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
                    @forelse ($users as $user)
                        <tr class="border-b">
                            <th
                                class="whitespace-nowrap px-6 py-4 font-medium text-gray-900"
                                scope="row"
                            >
                                {{ $user->name }}
                            </th>

                            <td class="px-6 py-4">
                                {{ $user->phone_number }}
                            </td>

                            <td class="px-6 py-4">
                                {{ ucwords(str_replace('_', ' ', $user->user_role)) }}
                            </td>

                            <td class="flex gap-x-2 px-6 py-4">
                                <a
                                    class="font-medium text-blue-600 hover:underline"
                                    href="{{ route('admin.user.show', $user) }}"
                                >
                                    View
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.user.destroy', $user) }}"
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
                                colspan="5"
                            >
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($users->total() > $users->count())
                <div class="mt-5">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </x-card>
</x-app-layout>
