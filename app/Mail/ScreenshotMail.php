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
use Illuminate\Support\Facades\Log;
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

        Log::info('Full path: '.$this->screenshot->image_data);
        Log::info('Existe: '.file_exists($this->screenshot->image_data));
        Log::info('Tamaño: '.filesize($this->screenshot->image_data));

        $imageData = base64_decode($this->screenshot->image_data);

        return [
            Attachment::fromData(fn() => $imageData, $this->screenshot->filename)
                ->withMime('image/png'),
        ];
    }
}
