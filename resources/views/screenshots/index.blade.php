<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Screenshots') }}
            </h2>
            <a href="{{ route('visualizer.index') }}"
               class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                🎨 Create New Visualization
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($screenshots->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <div class="text-6xl mb-4">📸</div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">No screenshots yet</h3>
                    <p class="text-gray-600 mb-6">Start creating amazing audio visualizations and capture your favorite moments!</p>
                    <a href="{{ route('visualizer.index') }}"
                       class="inline-block bg-purple-500 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg">
                        Get Started →
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($screenshots as $screenshot)
                        <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                            <div class="relative group">
                                <img src="{{ Storage::url($screenshot->path) }}"
                                     alt="Screenshot"
                                     class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <a href="{{ Storage::url($screenshot->path) }}"
                                       download="{{ $screenshot->filename }}"
                                       class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-purple-100 transition-colors">
                                        Download
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-gray-600">
                                        {{ $screenshot->created_at->diffForHumans() }}
                                    </span>
                                    @if($screenshot->sent_at)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                            ✓ Sent
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $screenshot->filename }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Created: {{ $screenshot->created_at->format('M d, Y g:i A') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $screenshots->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
