<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Spatie\Permission\Models\Role;

Class UserEdit extends Component
{
    public 
        $user,
        $firstName,
        $lastName,
        $email,
        $password,
        $updatePassword,
        $roles,
        $selectedRoles = [];

    public function mount()
    {
        $this->firstName = $this->user->first_name;
        $this->lastName = $this->user->last_name;
        $this->email = $this->user->email;
        $currentRoles = $this->user->getRoleNames();
        $this->selectedRoles = Role::whereIn('name',$currentRoles->toArray())->pluck('id')->toArray();
        $this->roles = Role::all();
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function rules()
    {
        $data = [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => ['required','email',Rule::unique('sec_users')->ignore($this->user->id_usr, 'id_usr')],
            // 'email' => 'required|email',
            'selectedRoles.*' => 'required|exists:roles,id'
        ];
        if(isset($this->updatePassword))
        {
            $data['password'] = 'required';
        }
        return $data;
    }

    public function render()
    {
        return view('class UserEdit');
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
        ];
        if(isset($this->updatePassword))
        {
            $data['password'] = bcrypt($this->password);
            $data['password_usr'] = $oldPasswordSystem;
        }
        // dd($this->selectedRoles);
        // $this->selectedRoles = array_values(array_filter($this->selectedRoles->toArray()));
        $this->user->update($data);
        $this->user->syncRoles($this->selectedRoles);
        Session::flash('successMessage','Usuario actualizado exitosamente');
        return redirect()->route('admin.users.index');
    }
}
