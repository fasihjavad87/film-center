<?php

namespace App\Livewire\UserAdmin\Permissions;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsEdite extends Component
{
    public Permission $permission;

    public $name;

    public function mount(Permission $permission): void
    {
        $this->permission = $permission;
        $this->name     = $permission->name;
    }

    protected function rules()
    {
        return [
            'name'   => 'required|string|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->permission->name   = $this->name;

        $this->permission->save();

        $this->redirect(route('panelAdmin.permissions.index'));
//        return $this->redirect(route('panelAdmin.permissions.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.permissions.permissions-edite');
    }
}
