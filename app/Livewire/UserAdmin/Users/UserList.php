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
    public $userIdToDelete = null;
    public $userNameToDelete = '';


    public function openDeleteModal($userId , $userName)
    {
        $this->userIdToDelete = $userId;
        $this->userNameToDelete = $userName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $user = User::find($this->userIdToDelete);
        if ($user) {
            $user->delete();

            $this->dispatch('toast-notification', [
                'message' => 'کاربر به صورت موقت حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-trailer-modal');
        $this->resetPage();
        $this->userIdToDelete = null;
        $this->userNameToDelete = '';
    }

    #[Layout('panel-admin.master')]
    public function render(): View
    {
        $users = User::query()
            ->with('roles')
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
