<x-app-layout>
    <x-card>
        <x-page-header>Manage Users</x-page-header>

        <div class="flex justify-between my-4">
            <div class="w-1/3">
                <form method="GET" action="">
                    <x-search-input name="search" placeholder="Search user..." value="{{ request('search') }}" />
                </form>
            </div>

            <x-button-link href="{{ route('admin.user.create') }}">Add New User</x-button-link>
        </div>

        <div class="overflow-x-auto shadow-md mt-6">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs uppercase text-gray-700 bg-gray-50">
                    <tr>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Phone Number</th>
                        <th class="px-6 py-3">User Role</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="font-medium text-gray-900 px-6 py-4">
                            {{ $user->name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $user->email }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $user->phone_number }}
                        </td>

                        <td class="px-6 py-4">
                            {{ ucwords(str_replace('_', ' ', $user->user_role)) }}
                        </td>

                        <td class="flex gap-x-2 px-6 py-4">
                            <a href={{ route('admin.user.show', $user) }}
                                class="font-medium text-blue-600 hover:underline">
                                View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center pt-4">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-6">
                {{ $users->links() }}
            </div>
        </div>
    </x-card>
</x-app-layout>