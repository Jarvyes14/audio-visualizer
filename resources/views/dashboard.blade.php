<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h3>
                    <p class="text-gray-600">You're logged in as
                        <span class="font-semibold text-purple-600">
                            {{ auth()->user()->roles->first()->name ?? 'user' }}
                        </span>
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Visualizer Card -->
                <a href="{{ route('visualizer.index') }}" class="block">
                    <div class="bg-gradient-to-br from-purple-500 to-pink-500 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300 h-full">
                        <div class="text-4xl mb-4">🎨</div>
                        <h3 class="text-xl font-bold mb-2">Audio Visualizer</h3>
                        <p class="text-purple-100">Create amazing 3D visualizations with your audio</p>
                        <div class="mt-4 text-sm font-semibold">
                            Launch Visualizer →
                        </div>
                    </div>
                </a>

                <!-- Screenshots Card -->
                <a href="{{ route('screenshots.index') }}" class="block">
                    <div class="bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300 h-full">
                        <div class="text-4xl mb-4">📸</div>
                        <h3 class="text-xl font-bold mb-2">My Screenshots</h3>
                        <p class="text-blue-100">View and download your captured visualizations</p>
                        <div class="mt-4 text-sm font-semibold flex items-center justify-between">
                            <span>View Gallery →</span>
                            <span class="bg-white bg-opacity-20 px-2 py-1 rounded">
                                {{ auth()->user()->screenshots()->count() }}
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Profile Card -->
                <a href="{{ route('profile.edit') }}" class="block">
                    <div class="bg-gradient-to-br from-green-500 to-teal-500 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300 h-full">
                        <div class="text-4xl mb-4">⚙️</div>
                        <h3 class="text-xl font-bold mb-2">Profile Settings</h3>
                        <p class="text-green-100">Manage your account and preferences</p>
                        <div class="mt-4 text-sm font-semibold">
                            Edit Profile →
                        </div>
                    </div>
                </a>

                @if(auth()->user()->hasRole('admin'))
                    <!-- Admin Panel Card (solo para admins) -->
                    <a href="{{ route('admin.users.index') }}" class="block">
                        <div class="bg-gradient-to-br from-red-500 to-orange-500 rounded-lg shadow-lg p-6 text-white hover:shadow-xl transition-shadow duration-300 h-full">
                            <div class="text-4xl mb-4">👥</div>
                            <h3 class="text-xl font-bold mb-2">User Management</h3>
                            <p class="text-red-100">Manage users and permissions</p>
                            <div class="mt-4 text-sm font-semibold">
                                Admin Panel →
                            </div>
                        </div>
                    </a>
                @endif
            </div>

            <!-- Recent Activity -->
            @if(auth()->user()->screenshots()->exists())
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Screenshots</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach(auth()->user()->screenshots()->latest()->take(4)->get() as $screenshot)
                                <div class="relative group">
                                    <img src="{{ Storage::url($screenshot->path) }}"
                                         alt="Screenshot"
                                         class="w-full h-32 object-cover rounded-lg">
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                        <span class="text-white text-xs">
                                            {{ $screenshot->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
