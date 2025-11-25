<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\Jobs\SendScreenshotEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ScreenshotController extends Controller
{
    public function capture(Request $request)
    {
        Log::info('Screenshot capture started', ['user_id' => auth()->id()]);

        try {
            $request->validate([
                'image' => 'required|string',
            ]);

            $imageData = $request->input('image');
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $decodedImage = base64_decode($imageData);

            if (!$decodedImage) {
                throw new \Exception('Failed to decode image data');
            }

            $filename = 'screenshot_' . auth()->id() . '_' . time() . '.png';
            $publicPath = 'screenshots/' . $filename;
            $fullPath = public_path($publicPath);

            if (!file_exists(public_path('screenshots'))) {
                mkdir(public_path('screenshots'), 0755, true);
            }

            $saved = file_put_contents($fullPath, $decodedImage);

            if ($saved === false) {
                throw new \Exception('Failed to save file');
            }

            $screenshot = Screenshot::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'path' => $publicPath,
            ]);

            Log::info('Screenshot saved, queuing email', ['screenshot_id' => $screenshot->id]);

            // Enviar email de forma ASÍNCRONA (no bloquea la respuesta)
            SendScreenshotEmail::dispatch(auth()->user(), $screenshot);

            // Responder INMEDIATAMENTE
            return response()->json([
                'success' => true,
                'message' => 'Screenshot captured! Email will be sent shortly.',
                'screenshot' => [
                    'id' => $screenshot->id,
                    'url' => asset($publicPath),
                    'filename' => $filename
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Screenshot capture error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $screenshots = Screenshot::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('screenshots.index', compact('screenshots'));
    }

    public function resend(Screenshot $screenshot)
    {
        if ($screenshot->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        try {
            SendScreenshotEmail::dispatch(auth()->user(), $screenshot);

            return response()->json([
                'success' => true,
                'message' => 'Email will be sent shortly!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
