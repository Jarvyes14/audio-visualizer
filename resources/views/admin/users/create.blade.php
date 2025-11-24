<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('Create New User') }}
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
                    <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-200">
                                Name
                            </label>
                            <input id="name"
                                   type="text"
                                   name="name"
                                   value="{{ old('name') }}"
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
                                   value="{{ old('email') }}"
                                   required
                                   class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
                            @error('email')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-200">
                                Password
                            </label>
                            <input id="password"
                                   type="password"
                                   name="password"
                                   required
                                   class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
                            @error('password')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-200">
                                Confirm Password
                            </label>
                            <input id="password_confirmation"
                                   type="password"
                                   name="password_confirmation"
                                   required
                                   class="mt-1 block w-full rounded-md bg-gray-700 border-gray-600 text-gray-100 focus:border-purple-500 focus:ring-purple-500">
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
                                <option value="">Select a role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
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
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="rounded bg-gray-700 border-gray-600 text-purple-600 focus:ring-purple-500">
                            <label for="is_active" class="ml-2 block text-sm text-gray-200">
                                Active User
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4">
                            <a href="{{ route('admin.users.index') }}"
                               class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit"
                                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
