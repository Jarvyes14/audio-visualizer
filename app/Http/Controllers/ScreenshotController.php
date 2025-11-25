<?php

namespace App\Http\Controllers;

use App\Models\Screenshot;
use App\Mail\ScreenshotMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ScreenshotController extends Controller
{
    public function capture(Request $request)
    {
        $request->validate([
            'image' => 'required|string', // Base64 string
        ]);

        try {
            // Decodificar la imagen base64
            $imageData = $request->input('image');

            // Remover el prefijo data:image/png;base64,
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $decodedImage = base64_decode($imageData);

            // Validar que se decodificó correctamente
            if (!$decodedImage) {
                throw new \Exception('Failed to decode image data');
            }

            // Generar nombre único para el archivo
            $filename = 'screenshot_' . auth()->id() . '_' . time() . '.png';
            $path = 'screenshots/' . $filename;

            // Guardar en storage/app/public/screenshots/
            $saved = Storage::disk('public')->put($path, $decodedImage);

            if (!$saved) {
                throw new \Exception('Failed to save screenshot file');
            }

            // Verificar que el archivo se guardó correctamente
            $fullPath = storage_path('app/public/' . $path);
            if (!file_exists($fullPath)) {
                throw new \Exception('Screenshot file was not saved correctly');
            }

            // Guardar registro en base de datos
            $screenshot = Screenshot::create([
                'user_id' => auth()->id(),
                'filename' => $filename,
                'path' => $path,
                'image_data' => base64_encode($decodedImage),
            ]);

            // Enviar email
            $user = auth()->user();
            Mail::to($user->email)->send(new ScreenshotMail($user, $screenshot));

            // Actualizar timestamp de envío
            $screenshot->update(['sent_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Screenshot captured and sent to your email!',
                'screenshot' => $screenshot
            ]);

        } catch (\Exception $e) {
            \Log::error('Screenshot capture error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error capturing screenshot: ' . $e->getMessage()
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
        // Verificar que el screenshot pertenece al usuario actual
        if ($screenshot->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        try {
            $user = auth()->user();

            // Enviar email
            Mail::to($user->email)->send(new ScreenshotMail($user, $screenshot));

            // Actualizar timestamp de envío
            $screenshot->update(['sent_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'Screenshot sent successfully to your email!',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending email: ' . $e->getMessage()
            ], 500);
        }
    }
}
