<?php

namespace App\Mail;

use App\Models\Screenshot;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ScreenshotMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public User $user,
        public Screenshot $screenshot
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎨 Your Audio Visualizer Screenshot',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.screenshot',
        );
    }

    public function attachments(): array
    {
        // Obtener la ruta completa del archivo
        $fullPath = storage_path('app/public/' . $this->screenshot->path);

        // Verificar que el archivo existe
        if (!file_exists($fullPath)) {
            \Log::error('Screenshot file not found: ' . $fullPath);
            return [];
        }

        return [
            Attachment::fromPath($fullPath)
                ->as($this->screenshot->filename)
                ->withMime('image/png'),
        ];
    }
}
