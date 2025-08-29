<?php

namespace App\Livewire\UserAdmin\Users;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $showDeleteModal = false;
    public $userIdToDelete = null;
//    public $users; // Property برای ذخیره لیست کاربران

    public function mount(): void
    {
//        $this->users = User::all(); // دریافت تمام کاربران از دیتابیس
    }

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
    public function delete()
    {
        // منطق حذف
        $user = User::find($this->userIdToDelete);
        if ($user) {
            $user->delete();

            $this->dispatch('toast-notification', [
                'message' => 'کاربر به صورت موقت حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->closeDeleteModal();
        $this->resetPage();
    }

    #[Layout('panel-admin.master')]
    public function render(): View
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);
        return view('livewire.user-admin.users.user-list', [
            'users' => $users,
        ]);
    }
}
