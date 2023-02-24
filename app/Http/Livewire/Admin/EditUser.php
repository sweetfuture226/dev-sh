<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;

class EditUser extends Component
{
    public $user_id, $name, $email, $role;
    public $user;

    protected $listeners = [
        'edit_user' => 'edit_user',
    ];

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,id,' . $this->user_id,
            'role' => 'required',
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
        ];
    }


    public function edit_user($id)
    {
        $this->user_id = $id;
        $this->user = User::find($id);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = $this->user->role;

    }

    public function update_user()
    {
        $this->validate();

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        $this->clearValidation();
        $this->reset();

        $this->emit('user_updated');
        $this->dispatchBrowserEvent('show-toast', ['message' => 'User Updated.']);
        $this->dispatchBrowserEvent('close-modal', ['id' => '#ModalEditUser']);

    }

    public function render()
    {
        return view('livewire.admin.edit-user');
    }
}
