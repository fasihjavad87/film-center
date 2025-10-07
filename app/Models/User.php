<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserStatus;
use App\Http\Traits\UserAccess;
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
    use HasFactory, Notifiable, HasRoles, softDeletes , UserAccess;

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
            'is_admin' => 'boolean',
        ];
    }


//    public function statusLabel(): string
//    {
//        return UserStatus::from($this->status)->label();
//    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'active' => 'فعال',
            'banned' => 'مسدود شده',
            'verified' => 'تایید شده',
            'unverified' => 'تایید نشده',
            default => 'نامشخص',
        };
    }

    // متد برای کلاس CSS وضعیت
    public function statusClasses(): string
    {
        return match($this->status) {
            'active' => 'bg-green-100 text-green-800 border-green-400/30 px-2 badge-custom-panel-form',
            'banned' => 'bg-red-100 text-red-800 border-red-400/30 px-2 badge-custom-panel-form',
            'verified' => 'bg-blue-100 text-blue-800 border-blue-400/30 px-2 badge-custom-panel-form',
            'unverified' => 'bg-yellow-100 text-yellow-800 border-yellow-400/30 px-2 badge-custom-panel-form',
            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
        };
    }


    public function roleLabel(): string
    {
        return $this->is_admin
            ? 'ادمین'
            : 'کاربر';
    }

    protected static function booted(): void
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

    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'user_id'); // تیکت‌هایی که باز کرده
    }

    public function assignedTickets()
    {
        return $this->hasMany(Tickets::class, 'assigned_to'); // تیکت‌هایی که بهش ارجاع داده شده
    }

}
