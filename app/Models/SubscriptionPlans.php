<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

class SubscriptionPlans extends Model
{
    protected $fillable = ['name', 'duration_days', 'price', 'discount_percent', 'description', 'is_active'];


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

//    public function finalPrice(): float
//    {
//
//        // اگر درصد تخفیف وجود نداشت یا صفر بود، همان قیمت اصلی را برمی‌گرداند.
//        if (empty($this->discount_percent) || $this->discount_percent <= 0) {
//            return (float) $this->price;
//        }
//
//        $discountAmount = $this->price * ($this->discount_percent / 100);
//        $finalPrice = $this->price - $discountAmount;
//
//        return round($finalPrice, 0); // قیمت نهایی را گرد کرده و برمی‌گرداند
//    }

    public function discountCodes(): BelongsToMany
    {
        return $this->belongsToMany(
            DiscountCode::class,
            'discount_code_plan', // جدول واسط
            'plan_id',            // کلید خارجی این مدل (SubscriptionPlans) در جدول واسط
            'discount_code_id'    // کلید خارجی مدل DiscountCode در جدول واسط
        )
            // 👇 شروط اعتبار کد تخفیف را مستقیماً اعمال می‌کنیم 👇
            ->where('discount_codes.expires_at', '>', Carbon::now()) // از نام جدول استفاده می‌کنیم تا ابهام نباشد
            ->where('discount_codes.is_active', 'active');
    }

    public function finalPrice(): float
    {
        $basePrice = (float) $this->price;
        $effectiveDiscountPercent = 0;

        // ۱. بررسی تخفیف مستقیم ثبت شده روی خود اشتراک (اولویت بالاتر)
        if (!empty($this->discount_percent) && $this->discount_percent > 0) {
            $effectiveDiscountPercent = $this->discount_percent;
        }

        // ۲. اگر تخفیف مستقیم نبود، تخفیف از کدهای تخفیف مرتبط را بررسی کن
        else {
            // این فراخوانی از رابطه اصلاح شده در بالا استفاده می‌کند
            $validDiscountCodes = $this->discountCodes;

            if ($validDiscountCodes->isNotEmpty()) {
                $maxCodePercent = $validDiscountCodes->pluck('percent')->max();

                if ($maxCodePercent > 0) {
                    $effectiveDiscountPercent = $maxCodePercent;
                }
            }
        }

        if ($effectiveDiscountPercent <= 0) {
            return $basePrice; // هیچ تخفیفی اعمال نشد
        }

        // محاسبه نهایی
        $discountAmount = $basePrice * ($effectiveDiscountPercent / 100);
        $finalPrice = $basePrice - $discountAmount;

        return round($finalPrice, 0);
    }

    public function hasDiscount(): bool
    {
        // قیمت نهایی محاسبه شده (با اعمال همه اولویت‌ها)
        $finalPrice = $this->finalPrice();

        // قیمت اصلی
        $basePrice = (float) $this->price;

        // اگر قیمت نهایی کمتر از قیمت اصلی بود، یعنی تخفیف اعمال شده است.
        // از round استفاده می‌کنیم تا خطاهای اعشاری ناچیز تأثیری نداشته باشند.
        return round($finalPrice, 0) < round($basePrice, 0);
    }

    public function effectiveDiscountPercent(): float
    {
        $effectiveDiscountPercent = 0;

        // ۱. بررسی تخفیف مستقیم (اولویت بالاتر)
        if (!empty($this->discount_percent) && $this->discount_percent > 0) {
            $effectiveDiscountPercent = $this->discount_percent;
        }

        // ۲. اگر تخفیف مستقیم نبود، تخفیف از کدهای تخفیف مرتبط را بررسی کن
        else {
            // از رابطه Eager Loaded استفاده می‌کند
            $validDiscountCodes = $this->discountCodes;

            if ($validDiscountCodes->isNotEmpty()) {
                $maxCodePercent = $validDiscountCodes->pluck('percent')->max();

                if ($maxCodePercent > 0) {
                    $effectiveDiscountPercent = $maxCodePercent;
                }
            }
        }

        return (float) $effectiveDiscountPercent;
    }

    public function subscriptions()
    {
        return $this->hasMany(UserSubscriptions::class, 'plan_id');
    }
}

