<?php

namespace App\Livewire\UserAdmin\Permissions;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class PermissionsList extends Component
{
    use WithPagination;

    public $search = '';
    public $permissionIdToDelete = null;
    public $permissionNameToDelete = '';


    public function openDeleteModal($permissionId , $permissionName)
    {
        $this->permissionIdToDelete = $permissionId;
        $this->permissionNameToDelete = $permissionName;
        $this->dispatch('show-delete-modal');
    }

    public function delete()
    {
        $permission = Permission::find($this->permissionIdToDelete);
        if ($permission) {
            $permission->delete();

            $this->dispatch('toast-notification', [
                'message' => 'مجوز حذف شد.',
                'duration' => 5000
            ]);
        }
        $this->dispatch('close-delete-modal');
        $this->resetPage();
        $this->permissionIdToDelete = null;
        $this->permissionNameToDelete = '';
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $permissions = Permission::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->paginate(20);
        return view('livewire.user-admin.permissions.permissions-list', ['permissions' => $permissions]);
    }
}
