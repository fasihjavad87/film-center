<?php

namespace App\Livewire\UserAdmin\Roles;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class RolesCreate extends Component
{

    public $name;

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    // این متد رو به کامپوننت Livewire اضافه کن

    public function save()
    {
        $this->validate();

        Role::create([
            'name' => $this->name,
        ]);

        return redirect()->route('panelAdmin.roles.index');
//        return $this->redirect(route('panelAdmin.roles.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.roles.roles-create');
    }
}
