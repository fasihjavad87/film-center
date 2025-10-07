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

//    public $showRestoreModal = false; // برای پاپ‌آپ بازگردانی
    public $userIdToDelete = null; // برای حذف دائم
    public $userIdToRestore = null; // برای بازگردانی
    public $userNameToDelete = '';
    public $userNameToRestore = '';
    public $search = '';


    public function openDeleteModal($userId , $userName)
    {
        $this->userIdToDelete = $userId;
        $this->userNameToDelete = $userName;
        $this->dispatch('show-delete-modal');
    }

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
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->userIdToDelete = null;
        $this->userNameToDelete = '';
    }

    public function openRestoreModal($userId , $userName)
    {
        $this->userIdToRestore = $userId;
        $this->userNameToRestore = $userName;
        $this->dispatch('show-restore-modal');
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
        }
        $this->dispatch('close-restore-modal');
        $this->resetPage();
        $this->userIdToRestore = null;
        $this->userNameToRestore = '';
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
