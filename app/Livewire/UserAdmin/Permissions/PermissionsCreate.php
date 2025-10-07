<?php

namespace App\Livewire\UserAdmin\Permissions;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Permission;

class PermissionsCreate extends Component
{
    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    // این متد رو به کامپوننت Livewire اضافه کن

    public function save()
    {
        $this->validate();

        Permission::create([
            'name' => $this->name,
        ]);

        return redirect()->route('panelAdmin.permissions.index');
//        return $this->redirect(route('panelAdmin.permissions.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.permissions.permissions-create');
    }
}
