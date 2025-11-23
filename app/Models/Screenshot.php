<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Screenshot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'filename',
        'path',
        'sent_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The user that owns the screenshot.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full URL for the screenshot.
     */
    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }

    /**
     * Mark the screenshot as sent.
     */
    public function markAsSent(): void
    {
        $this->update(['sent_at' => now()]);
    }

    /**
     * Check if the screenshot has been sent.
     */
    public function isSent(): bool
    {
        return !is_null($this->sent_at);
    }

    /**
     * Delete the screenshot file and record.
     */
    public function deleteWithFile(): bool
    {
        if (Storage::disk('public')->exists($this->path)) {
            Storage::disk('public')->delete($this->path);
        }

        return $this->delete();
    }
}
