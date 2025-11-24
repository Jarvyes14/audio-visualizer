<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Edit User') }}: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}"
               class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                ← Back to Users
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-200">
                                Name
                            </label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   autofocus
                                   class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
                            @error('name')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-200">
                                Email
                            </label>
                            <input id="email"
                                   type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
                            @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role_id" class="block text-sm font-medium text-gray-200">
                                Role
                            </label>
                            <select id="role_id"
                                    name="role_id"
                                    required
                                    class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ (old('role_id', $user->roles->first()->id ?? '') == $role->id) ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Active Status -->
                        <div class="flex items-center">
                            <input id="is_active"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', $user->is_active) ? 'checked' : '' }}
                                   class="rounded bg-gray-700 border-gray-600 text-purple-600 focus:ring-purple-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-200">
                                Active User
                            </label>
                        </div>

                        <!-- Info Box -->
                        <div class="bg-blue-900 border-l-4 border-blue-500 text-blue-200 p-4 rounded">
                            <p class="font-bold">Note:</p>
                            <p class="text-sm">Leave the password fields empty if you don't want to change the password.</p>
                        </div>

                        <!-- New Password (Optional) -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-200">
                                New Password (Optional)
                            </label>
                            <input id="password"
                                   type="password"
                                   name="password"
                                   class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
                            @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-200">
                                Confirm New Password
                            </label>
                            <input id="password_confirmation"
                                   type="password"
                                   name="password_confirmation"
                                   class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <!-- Additional Info -->
                        <div class="bg-gray-700 rounded-lg p-4 space-y-2 text-sm text-gray-300">
                            <p><strong>User ID:</strong> {{ $user->id }}</p>
                            <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y g:i A') }}</p>
                            <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y g:i A') }}</p>
                            <p><strong>Screenshots:</strong> {{ $user->screenshots()->count() }}</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.users.index') }}"
                               class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
