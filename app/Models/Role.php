<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The users that belong to the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user')
            ->withTimestamps();
    }

    /**
     * Find a role by name.
     */
    public static function findByName(string $name): ?self
    {
        return self::where('name', $name)->first();
    }

    /**
     * Create a new role if it doesn't exist.
     */
    public static function createIfNotExists(string $name, ?string $description = null): self
    {
        return self::firstOrCreate(
            ['name' => $name],
            ['description' => $description]
        );
    }

    /**
     * Get all role names.
     */
    public static function getAllNames(): array
    {
        return self::pluck('name')->toArray();
    }
}
