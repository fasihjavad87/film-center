<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatus;
use Filament\Models\Contracts\HasAvatar;
use Hekmatinasser\Verta\Verta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements  HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, softDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'avatar',
        'is_admin',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function statusLabel(): string
    {
        return UserStatus::from($this->status)->label();
    }


    public function roleLabel(): string
    {
        return $this->is_admin
            ? 'ادمین'
            : 'کاربر';
    }

    protected static function booted()
    {
        parent::booted();

        // هنگام بروزرسانی عکس، عکس قبلی رو حذف کن
        static::updating(function ($user) {
            if ($user->isDirty('avatar') && $user->getOriginal('avatar')) {
                Storage::disk('filament')->delete($user->getOriginal('avatar'));
            }
        });

        // هنگام حذف کامل کاربر، عکسش رو هم پاک کن
        static::deleting(function ($user) {
            if ($user->forceDeleting && $user->avatar) {
                Storage::disk('filament')->delete($user->avatar);
            }
        });
    }


    public function createdAtPersian(): string
    {
        return (new Verta($this->created_at))->format('Y/m/d');
    }


//    public function canAccessPanel(Panel $panel): bool
//    {
//        // TODO: Implement canAccessPanel() method.
//    }

    public function getFilamentAvatarUrl(): ?string
    {
        return asset('uploads/' . $this->avatar);
    }
}
