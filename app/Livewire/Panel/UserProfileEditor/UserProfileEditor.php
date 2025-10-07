<?php

namespace App\Livewire\Panel\UserProfileEditor;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserProfileEditor extends Component
{

    use WithFileUploads;

    // Public properties for form binding
    public $name = '';
    public $email = '';
    public $avatar;        // برای آپلود جدید (Livewire temporary file object)
    public $currentAvatar; // برای نمایش مسیر عکس فعلی از دیتابیس

    // پراپرتی برای نگهداری شیء کاربر فعلی
    public User $user;

    /**
     * Set the validation rules.
     */
    protected function rules()
    {
        // Get the current user ID to ignore in unique email check
        $userId = Auth::id();

        return [
            'name' => ['required', 'string', 'max:255'],
            // اعتبارسنجی ایمیل
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            // اعتبارسنجی آواتار
            'avatar' => ['nullable', 'image', 'max:2048', 'mimes:jpg,jpeg,png,webp'], // حداکثر 2 مگابایت، فرمت‌های مجاز
        ];
    }

    /**
     * Load the current user's data when the component is initialized.
     */
    public function mount()
    {
        // Check if the user is logged in
        if (Auth::check()) {
            $this->user = Auth::user();
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            // بارگذاری مسیر آواتار موجود در دیتابیس (فرض می‌کنیم ستون 'avatar' نام دارد)
            $this->currentAvatar = $this->user->avatar;
        } else {
            // اگر کاربر احراز هویت نشده باشد
            abort(403);
        }
    }

    /**
     * Handles saving the updated profile information.
     */
    public function updateProfile()
    {
        // 1. اجرای اعتبارسنجی
        $validatedData = $this->validate();

        // 2. به‌روزرسانی داده‌های کاربر در مدل
        $this->user->name = $validatedData['name'];
        $this->user->email = $validatedData['email'];


        // 3. مدیریت آپلود آواتار
        if ($this->avatar) {

            // اگر عکس آواتار قبلی وجود داشت، آن را حذف کن (با استفاده از دیسک 'filament')
            if ($this->currentAvatar) {
                Storage::disk('filament')->delete($this->currentAvatar);
            }

            // ذخیره آواتار جدید در دیسک 'filament'
            $path = $this->avatar->store('avatars', 'filament');

            // به‌روزرسانی مدل و پراپرتی currentAvatar
            $this->user->avatar = $path;
            $this->currentAvatar = $path;

            // پاک کردن آبجکت فایل موقت در Livewire
            $this->avatar = null;
        }

        // 4. ذخیره مدل
        $this->user->save();

        // 5. ارسال پیام موفقیت
        $this->dispatch('toast-notification', [
            'message' => "اطلاعات ویرایش شد.",
            'duration' => 4000
        ]);

        // Optional: ارسال دستور برای ریست کردن ورودی فایل در سمت کلاینت
        $this->dispatch('resetFileInput');
    }

    #[Layout('panel.master')]
    public function render(): View
    {
        return view('livewire.panel.user-profile-editor.user-profile-editor');
    }
}
