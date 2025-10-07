<?php

namespace App\Livewire\UserAdmin\Roles;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RolesList extends Component
{
    use WithPagination;

    public $search = '';
    public $roleIdToDelete = null;
    public $roleNameToDelete = '';


    public function openDeleteModal($roleId , $roleName)
    {
        $this->roleIdToDelete = $roleId;
        $this->roleNameToDelete = $roleName;
        $this->dispatch('show-delete-modal');
    }


    public function delete()
    {
        $role = Role::find($this->roleIdToDelete);
        if ($role) {
            $role->delete();

            $this->dispatch('toast-notification', [
                'message' => 'نقش حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->roleIdToDelete = null;
        $this->roleNameToDelete = '';
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $roles = Role::query()
            ->with('permissions')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->paginate(10);
        return view('livewire.user-admin.roles.roles-list' , ['roles' => $roles]);
    }
}
