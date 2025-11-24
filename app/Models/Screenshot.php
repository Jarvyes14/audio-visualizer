<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Screenshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filename',
        'path',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getUrlAttribute(): string
    {
        // Si la ruta comienza con 'screenshots/', usar asset directamente
        // Si comienza con 'storage/', también funciona
        return asset($this->path);
    }

    public function markAsSent(): void
    {
        $this->update(['sent_at' => now()]);
    }

    public function isSent(): bool
    {
        return !is_null($this->sent_at);
    }

    public function deleteWithFile(): bool
    {
        $filePath = public_path($this->path);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return $this->delete();
    }
}
