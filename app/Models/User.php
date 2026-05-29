<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected static function booted(): void
    {
        static::deleting(function (User $user): void {
            if (Auth::id() === $user->getKey()) {
                throw new RuntimeException('You cannot delete your own account.');
            }

            if ($user->role === 'superadmin' && static::query()->where('role', 'superadmin')->count() <= 1) {
                throw new RuntimeException('You cannot delete the last superadmin account.');
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active === true;
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function orders(): HasMany   
    {
        return $this->hasMany(Order::class, 'admin_id');
    }

    public function uploadedFiles(): HasMany
    {
        return $this->hasMany(OrderFile::class, 'uploaded_by');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class, 'changed_by');
    }
}
