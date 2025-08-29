<?php

namespace App\Livewire\UserAdmin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UserSoftDelete extends Component
{

    use WithPagination;

    // پراپرتی‌ها برای مدیریت پاپ‌آپ حذف
    public $showDeleteModal = false; // برای پاپ‌آپ حذف دائم
    public $showRestoreModal = false; // برای پاپ‌آپ بازگردانی
    public $userIdToDelete = null; // برای حذف دائم
    public $userIdToRestore = null; // برای بازگردانی
    public $search = '';

    public function openDeleteModal($userId)
    {
        $this->showDeleteModal = true;
        $this->userIdToDelete = $userId;
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->userIdToDelete = null;
    }

    // متد برای حذف دائمی کاربر
    public function forceDelete()
    {
        $user = User::onlyTrashed()->find($this->userIdToDelete);

        if ($user) {
            $user->forceDelete();

            // نمایش پیغام موفقیت
            $this->dispatch('toast-notification', [
                'message' => 'کاربر به صورت دائمی حذف شد.',
                'duration' => 5000
            ]);
        }

        $this->closeDeleteModal();
    }
    public function openRestoreModal($userId)
    {
        $this->showRestoreModal = true;
        $this->userIdToRestore = $userId;
    }

    public function closeRestoreModal()
    {
        $this->showRestoreModal = false;
        $this->userIdToRestore = null;
    }

    public function restore()
    {
        $user = User::onlyTrashed()->find($this->userIdToRestore);

        if ($user) {
            $user->restore();

            $this->dispatch('toast-notification', [
                'message' => 'کاربر با موفقیت بازیابی شد.',
                'duration' => 5000
            ]);
            $this->resetPage();
        }

        $this->closeRestoreModal();
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $trashedUsers = User::onlyTrashed()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.user-admin.users.user-soft-delete' , ['trashedUsers' => $trashedUsers] );
    }
}
