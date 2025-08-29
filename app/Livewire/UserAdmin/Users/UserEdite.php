<?php

namespace App\Livewire\UserAdmin\Users;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserEdite extends Component
{

    use WithFileUploads;

    public User $user;

    public $name;
    public $email;
    public $status;
    public $is_admin;
    public $password;
    public $remove_password = false;
    public $avatar;        // برای آپلود جدید
    public $currentAvatar;

    public function mount(User $user): void
    {
        $this->user   = $user;
        $this->name   = $user->name;
        $this->email  = $user->email;
        $this->status = $user->status;
        $this->is_admin  = (bool) $user->is_admin;
        // آواتار موجود
//        $this->avatar = $user->avatar;
        $this->currentAvatar = $user->avatar;
    }

    protected function rules()
    {
        return [
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $this->user->id,
            'status' => 'required|in:' . implode(',', array_map(fn($case) => $case->value, UserStatus::cases())),
            'is_admin' => 'boolean',
            'password' => $this->remove_password ? 'nullable' : 'nullable|min:8',
            'avatar'   => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->user->name   = $this->name;
        $this->user->email  = $this->email;
        $this->user->status = $this->status;
        $this->user->is_admin = $this->is_admin;

        // رمز
        if ($this->remove_password) {
            $this->user->password = null;
        } elseif ($this->password) {
            $this->user->password = Hash::make($this->password);
        }

        // آواتار
        if ($this->avatar instanceof \Illuminate\Http\UploadedFile) {
            $path = $this->avatar->store('avatars', 'filament');
            $this->user->avatar = $path;
        } else {
            // اگر تصویری آپلود نشد → همون قبلی باقی بمونه
            $this->user->avatar = $this->currentAvatar;
        }

        $this->user->save();

        session()->flash('success', 'کاربر با موفقیت ویرایش شد.');
        return redirect()->route('panelAdmin.users.index');
    }

    #[Layout('panel-admin.master')]
    public function render():View
    {
        return view('livewire.user-admin.users.user-edite');
    }
}
