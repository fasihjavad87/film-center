<?php

namespace App\Livewire\UserAdmin\Roles;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesEdite extends Component
{

    public Role $role;

    public $name;
//    public $allPermissions;
    public $selectedPermissions = [];


    protected function rules()
    {
        return [
            'name'   => 'required|string|max:255',
            'selectedPermissions' => 'required|array',
        ];
    }

    public function mount(Role $role)
    {
        $this->role = $role;
        $this->name = $role->name;

        // 1. بارگذاری تمام مجوزها
//        $this->allPermissions = Permission::all();

        // 2. بارگذاری مجوزهای فعلی نقش در آرایه انتخاب شده
//        $this->selectedPermissions = $role->permissions->pluck('name')->map(fn($id) => (string) $id)->toArray();
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
    }

    public function save()
    {
        $this->validate();

        $this->role->update(['name' => $this->name]);
        $this->role->syncPermissions($this->selectedPermissions);

        $this->redirect(route('panelAdmin.roles.index'));
//        return $this->redirect(route('panelAdmin.roles.index'), navigate: true);
    }


    #[Layout('panel-admin.master')]
    public function render():View
    {
        $this->dispatch('init-custom-select');
        return view('livewire.user-admin.roles.roles-edite', [
            'allPermissions' => Permission::all(),
        ]);
    }
}
