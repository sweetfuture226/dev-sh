<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class CreateUser extends Component
{
    public $name, $email, $role, $password, $password_confirmation;

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Required.',
            'email.required' => 'Required.',
            'email.email' => 'Invalid email.',
            'email.unique' => 'Already exists.',
            'role.required' => 'Required.',
            'password.required' => 'Required.',
            'password.confirmed' => 'Both passwords should match',
        ];
    }


    public function add_user()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => bcrypt($this->password),
            'is_admin' => 0,
        ]);

        $this->clearValidation();
        $this->reset();

        $this->emit('user_added');
        $this->dispatchBrowserEvent('show-toast', ['message' => 'User created.']);
        $this->dispatchBrowserEvent('close-modal', ['id' => '#ModalAddUser']);

    }

    public function render()
    {
        return view('livewire.admin.create-user');
    }
}
