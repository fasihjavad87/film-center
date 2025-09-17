<?php

namespace App\Livewire\UserAdmin\Users;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserCreate extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $status;
    public $is_admin = false;
    public $password;
    public $remove_password = false;
    public $avatar;
    public $password_confirmation;
    protected $listeners = ['fileUpdated' => 'setAvatar'];

    public function setAvatar($file): void
    {
        $this->avatar = $file;
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'status' => 'required',
        'is_admin' => 'boolean',
        'password' => 'nullable|min:8',
        'avatar' => 'nullable|image|max:700|mimes:png,jpg,jpeg',
    ];

    public function save()
    {
        $this->validate();


        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->status,
            'is_admin' => $this->is_admin,
            'password' => $this->password ? Hash::make($this->password) : null,
        ]);

        if ($this->avatar) {
            $path = $this->avatar->store('avatars', 'filament');
            $user->update(['avatar' => $path]);
        }

//        return redirect()->route("panelAdmin.users.index");
        return $this->redirect(route('panelAdmin.users.index'), navigate: true);
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.users.user-create');
    }
}
