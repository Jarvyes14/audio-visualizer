<?php

namespace App\Jobs;

use App\Mail\ScreenshotMail;
use App\Models\Screenshot;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendScreenshotEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120; // 2 minutos máximo
    public $tries = 3; // 3 intentos

    public function __construct(
        public User $user,
        public Screenshot $screenshot
    ) {}

    public function handle(): void
    {
        try {
            Log::info('Sending screenshot email', [
                'user_id' => $this->user->id,
                'screenshot_id' => $this->screenshot->id
            ]);

            Mail::to($this->user->email)->send(new ScreenshotMail($this->user, $this->screenshot));

            $this->screenshot->update(['sent_at' => now()]);

            Log::info('Screenshot email sent successfully');

        } catch (\Exception $e) {
            Log::error('Failed to send screenshot email', [
                'error' => $e->getMessage(),
                'user_id' => $this->user->id,
                'screenshot_id' => $this->screenshot->id
            ]);

            // Si falla, reintentará automáticamente
            throw $e;
        }
    }
}
