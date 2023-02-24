<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithPagination;

    protected $listeners = [
        'user_added' => '$refresh',
        'user_updated' => '$refresh',
    ];

    public function delete_user($id)
    {
        if($user = User::find($id)) {

            $user->delete();

            $this->dispatchBrowserEvent('show-toast', ['message' => 'User deleted.']);

        }
    }


    public function render()
    {
        $users = User::query()
            ->normalUsers()
            ->orderBy('role')
            ->paginate(10);

        return view('livewire.admin.list-users', compact('users'));
    }
}
