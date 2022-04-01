<?php

namespace App\Http\Livewire\admin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    public 
        $name,
        $email,
        $password,
        $roles,
        $roleId;


    public function mount()
    {
        $this->roleId = 1;
        $this->roles = Role::all();
    }
    public function render()
    {
        return view('livewire.admin.user-create');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'roleId' => 'required'
        ];
    }

    public function save()
    {
        $this->validate();
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password)
        ];
        $role = Role::find($this->roleId);
        $user = User::create($data);
        $user->assignRole($role->name);
        return redirect()->route('admin.users.index');
    }
}
