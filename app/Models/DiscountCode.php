<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DiscountCode extends Model
{
    protected $fillable = ['code', 'percent', 'max_usage' , 'is_active' , 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function expiresInDays(): array
    {
        // اگر تاریخ انقضا وجود ندارد یا گذشته است
        if (empty($this->expires_at) || $this->expires_at->isPast()) {
            return [
                'days' => 0,
                'label' => 'منقضی شده',
            ];
        }

        // محاسبه روزهای باقی‌مانده (فقط تعداد روزها، بدون ساعت)
        $remainingDays = floor(now()->diffInDays($this->expires_at, true));

        if ($remainingDays <= 1) { // تغییر شرط برای پوشش 'امروز' و 'فردا'
            $label = $remainingDays === 1 ? 'فردا' : 'امروز';
        } else {
            $label = "{$remainingDays} روز";
        }

        return [
            'days' => (int)$remainingDays, // اطمینان از اینتیجر بودن
            'label' => $label,
        ];
    }

    public function expiresInClasses(): string
    {
        $data = $this->expiresInDays();
        $days = $data['days'];

        // اگر منقضی شده، کلاس خاصی برمی‌گردد
        if ($days === 0 && $data['label'] === 'منقضی شده') {
            return 'bg-red-100 text-red-800 border-red-400/30';
        }

        return match(true) {
                $days <= 1 => 'bg-red-100 text-red-800 border-red-400/30',        // امروز یا فردا (قرمز تیره)
                $days <= 5 => 'bg-red-100 text-red-800 border-red-400/30',        // کمتر از ۵ روز (قرمز)
                $days <= 12 => 'bg-yellow-100 text-yellow-800 border-yellow-400/30', // کمتر از ۱۲ روز (نارنجی)
                default => 'bg-green-100 text-green-800 border-green-400/30',      // بیشتر از ۱۲ روز (سبز)
            } . ' px-2 badge-custom-panel-form';
    }


    public function statusLabel(): string
    {
        return match($this->is_active) {
            'active' => 'فعال',
            'inactive' => 'غیر فعال',
            default => 'نامشخص',
        };
    }

    // متد برای کلاس CSS وضعیت
    public function statusClasses(): string
    {
        return match($this->is_active) {
            'active' => 'bg-green-100 text-green-800 border-green-400/30 px-2 badge-custom-panel-form',
            'inactive' => 'bg-red-100 text-red-800 border-red-400/30 px-2 badge-custom-panel-form',
            default => 'bg-gray-200 text-gray-600 px-2 badge-custom-panel-form',
        };
    }

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(SubscriptionPlans::class, 'discount_code_plan' , 'discount_code_id' , 'plan_id' );
    }
    public function usages()
    {
        return $this->hasMany(DiscountCodeUsages::class);
    }

    public function isValid(): bool
    {
        if ($this->expires_at && now()->greaterThan($this->expires_at)) {
            return false;
        }

        if ($this->max_usage && $this->usages()->count() >= $this->max_usage) {
            return false;
        }

        return true;
    }

    public function markUsed(int $userId): bool
    {
        // ۱. بررسی اینکه آیا کاربر قبلاً از این کد استفاده کرده است؟
        $alreadyUsed = $this->usages()->where('user_id', $userId)->exists();
        if ($alreadyUsed) {
            // کاربر قبلاً از این کد استفاده کرده و طبق سیاست شما نمی‌تواند دوباره استفاده کند.
            return false;
        }

        // ۲. ثبت استفاده جدید
        $this->usages()->create([
            'user_id' => $userId,
        ]);

        // ۳. بررسی سقف استفاده کلی (Max Usage)
        if ($this->max_usage !== null) {
            $currentUsageCount = $this->usages()->count();

            if ($currentUsageCount >= $this->max_usage) {
                // سقف استفاده رسیده است، وضعیت را به 'inactive' تغییر بده
                $this->update(['is_active' => 'inactive']);
            }
        }

        return true; // استفاده موفقیت‌آمیز ثبت شد
    }

    protected static function booted(): void
    {
        static::deleting(function ($discountCode) {
            $discountCode->plans()->detach();
        });
    }
}

