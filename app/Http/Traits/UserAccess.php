<?php
//
//namespace App\Http\Traits;
//
//trait UserAccess
//{
//    public function isSuperAdmin(): bool
//    {
//        $user = auth()->user();
//        return $user->id === 1 || $user->is_admin || $user->hasRole('administrator');
//    }
//
//    public function isAdmin(string $permission): bool
//    {
//        $user = auth()->user();
//        return $user->isSuperAdmin() || $this->hasPermissionTo($permission);
//    }
//
//}


namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;

trait UserAccess
{

    /**
     * چک می کند که آیا کاربر، ادمین اصلی (Super Admin) با دسترسی نامحدود است.
     * این دسترسی در Gate::before استفاده می شود و تمام چک های مجوز را لغو می کند.
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        // در اینجا $this مدل User است
        $user = $this;

        // دسترسی نامحدود فقط برای ID=1 یا فیلد is_admin=true محفوظ است. (Bypass سراسری)
        return $user->id === 1 ||$this->hasRole('administrator');
    }

    /**
     * چک می کند که آیا کاربر مجاز به ورود به پنل ادمین است یا خیر (Super Admin یا Administrator Role).
     * این متد برای AdminMiddleware استفاده می شود.
     * @return bool
     */
    public function canEnterAdminPanel(): bool
    {
        $user = $this;
        // اجازه ورود به Super Admin ها (که از isSuperAdmin می آیند)
        // و همچنین کاربران دارای نقش 'administrator' را می دهد.
        return $this->isSuperAdmin() || $user->is_admin;
    }


    /**
     * چک می کند که آیا کاربر ادمین است (چه سوپر ادمین چه ساب ادمین).
     *
     * @param string $permission نام مجوز مورد نیاز (مثلاً 'tickets_view')
     * @return bool
     */
    public function isAdmin(string $permission): bool
    {
        // 1. چک کردن سطح دسترسی سوپر ادمین (Bypass سراسری)
        if ($this->isSuperAdmin()) {
            return true;
        }

        // 2. چک می کند آیا کاربر مجوز مورد نظر ($permission) را دارد.
        // توجه: این چک فقط برای Roleهایی است که دسترسی نامحدود ندارند (مانند 'administrator').
        return $this->hasPermissionTo($permission);
    }

    /**
     * این متد برای سازگاری با کد قبلی است.
//     *
//     * @param string $permission نام مجوز مورد نیاز (مثلاً 'tickets_view')
//     * @return bool
//     */
//    public function hasAccessTo(string $permission): bool
//    {
//        return $this->isAdmin($permission);
//    }
}
