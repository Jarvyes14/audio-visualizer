<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-100 leading-tight">
                {{ __('My Screenshots') }}
            </h2>
            <a href="{{ route('visualizer.index') }}"
               class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                🎨 Create New Visualization
            </a>
        </div>
    </x-slot>

    <style>
        .notification {
            position: fixed;
            top: 80px;
            right: 20px;
            background: rgba(0, 255, 100, 0.95);
            border: 1px solid rgba(0, 255, 100, 0.4);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 16px 24px;
            color: white;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 255, 100, 0.3);
            animation: slideIn 0.3s ease-out;
            display: none;
            max-width: 350px;
        }

        .notification.error {
            background: rgba(255, 0, 100, 0.95);
            border-color: rgba(255, 0, 100, 0.4);
            box-shadow: 0 4px 20px rgba(255, 0, 100, 0.3);
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOut {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .notification.hiding {
            animation: slideOut 0.3s ease-in;
        }

        .btn-send {
            transition: all 0.3s ease;
        }

        .btn-send:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-send.sending {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 50%, #667eea 100%);
            background-size: 200% auto;
            animation: shimmer 1.5s linear infinite;
        }

        @keyframes shimmer {
            to {
                background-position: 200% center;
            }
        }
    </style>

    <div class="notification" id="notification"></div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($screenshots->isEmpty())
                <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12 text-center">
                    <div class="text-6xl mb-4">📸</div>
                    <h3 class="text-2xl font-bold text-gray-100 mb-2">No screenshots yet</h3>
                    <p class="text-gray-400 mb-6">Start creating amazing audio visualizations and capture your favorite moments!</p>
                    <a href="{{ route('visualizer.index') }}"
                       class="inline-block bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-lg">
                        Get Started →
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($screenshots as $screenshot)
                        <div class="bg-gray-800 overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300 border border-gray-700">
                            <div class="relative group">
                                <img src="{{ Storage::url($screenshot->path) }}"
                                     alt="Screenshot"
                                     class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center gap-2">
                                    <button
                                        onclick="sendToEmail({{ $screenshot->id }})"
                                        class="btn-send bg-gradient-to-r from-purple-500 to-pink-500 text-white px-4 py-2 rounded-lg font-semibold hover:from-purple-600 hover:to-pink-600 transition-all shadow-lg"
                                        id="send-btn-{{ $screenshot->id }}">
                                        <span class="btn-text">📧 Send to Email</span>
                                    </button>
                                    <a href="{{ Storage::url($screenshot->path) }}"
                                       download="{{ $screenshot->filename }}"
                                       class="bg-white text-purple-600 px-4 py-2 rounded-lg font-semibold hover:bg-purple-100 transition-colors shadow-lg">
                                        💾 Download
                                    </a>
                                </div>
                            </div>
                            <div class="p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-gray-400">
                                        {{ $screenshot->created_at->diffForHumans() }}
                                    </span>
                                    @if($screenshot->sent_at)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded flex items-center gap-1">
                                            ✓ Sent
                                            <span class="text-xs opacity-75">{{ $screenshot->sent_at->diffForHumans() }}</span>
                                        </span>
                                    @else
                                        <span class="text-xs bg-gray-700 text-gray-300 px-2 py-1 rounded">
                                            Not sent
                                        </span>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 truncate">
                                    {{ $screenshot->filename }}
                                </p>
                                <p class="text-xs text-gray-600 mt-1">
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

    <script>
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = 'notification ' + (type === 'error' ? 'error' : '');
            notification.style.display = 'block';

            setTimeout(() => {
                notification.classList.add('hiding');
                setTimeout(() => {
                    notification.style.display = 'none';
                    notification.classList.remove('hiding');
                }, 300);
            }, 4000);
        }

        async function sendToEmail(screenshotId) {
            const button = document.getElementById(`send-btn-${screenshotId}`);
            const buttonText = button.querySelector('.btn-text');
            const originalText = buttonText.textContent;

            try {
                // Deshabilitar botón y mostrar estado de carga
                button.disabled = true;
                button.classList.add('sending');
                buttonText.textContent = '📤 Sending...';

                const response = await fetch(`/screenshot/${screenshotId}/resend`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.success) {
                    showNotification('✅ ' + data.message, 'success');
                    buttonText.textContent = '✓ Sent!';

                    // Recargar la página después de 2 segundos para actualizar el badge
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                } else {
                    showNotification('❌ ' + data.message, 'error');
                    buttonText.textContent = originalText;
                    button.disabled = false;
                    button.classList.remove('sending');
                }

            } catch (error) {
                console.error('Error:', error);
                showNotification('❌ Error sending email. Please try again.', 'error');
                buttonText.textContent = originalText;
                button.disabled = false;
                button.classList.remove('sending');
            }
        }
    </script>
</x-app-layout>
