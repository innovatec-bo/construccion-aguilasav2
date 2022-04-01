<?php

namespace App\Http\Livewire\admin;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class UserCreate extends Component
{
    public 
        $firstName,
        $lastName,
        $email,
        $password,
        $roles,
        $selectedRoles;


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
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:sec_users,email',
            'password' => 'required',
            'selectedRoles.*' => 'required|exists:roles,name'
        ];
    }

    public function save()
    {
        $this->validate();
		$oldPasswordSystem = password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 10]);
        $data = [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'firstname_usr' => $this->firstName,
            'lastname_usr' => $this->lastName,
            'email' => $this->email,
            'email_usr' => $this->email,
            'password' => bcrypt($this->password),
            'password_usr' => $oldPasswordSystem
        ];

        $this->selectedRoles = array_values(array_filter($this->selectedRoles));
        $user = User::create($data);
        $user->syncRoles($this->selectedRoles);
        return redirect()->route('admin.users.index');
    }
}
