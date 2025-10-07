<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
//use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // ----------------------------------------------------------------------
        // تعریف گیت ادمین برای دسترسی نامحدود
        // این گیت، تمام چک‌های مجوز (can()) را برای ادمین نادیده می‌گیرد.
        // ----------------------------------------------------------------------
        Gate::before(function ($user, $ability) {

            // فرض می‌کنیم که متد isSuperAdmin بر روی مدل User شما یا Trait آن تعریف شده است.
            // 1. بررسی کنید آیا کاربر سوپر ادمین است (با استفاده از منطق سفارشی شما)
            // اگر isSuperAdmin() در مدل User شما موجود باشد، این کار خواهد کرد.
            if ($user->canEnterAdminPanel()) {
                // اگر کاربر سوپر ادمین بود (چه با ID=1، چه با hasRole("ادمین")، و چه با is_admin)،
                // دسترسی کامل بده (True) و چک کردن مجوزها را متوقف کن.
                return true;
            }

            // 2. اگر نقش ادمین را نداشت، به چک کردن مجوزهای عادی ادامه بده
            return null;
        });
    }
}
