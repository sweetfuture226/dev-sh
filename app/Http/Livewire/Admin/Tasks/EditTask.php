<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class EditTask extends Component
{
    public function render()
    {
        $users = User::normalUsers()->get();

        return view('livewire.admin.tasks.edit-task', compact('users'));
    }

    public $task_id, $content, $user_id, $description, $phone;
    public $task;

    protected $listeners = [
        'edit_task' => 'edit_task',
    ];

    public function rules()
    {
        return [
            'content'     => 'required',
            'description' => 'required',
            'phone'       => 'required',
            'user_id'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'content.required'     => 'Required.',
            'description.required' => 'Required.',
            'phone.required'       => 'Required.',
            'user_id.required'     => 'Required',
        ];
    }


    public function edit_task($id)
    {
        $this->task        = Task::find($id);
        $this->content     = $this->task->content;
        $this->phone       = $this->task->phone;
        $this->description = $this->task->description;
        $this->user_id     = $this->task->user_id;
    }

    public function update_task()
    {
        $this->validate();

        $this->task->update([
            'content'     => $this->content,
            'description' => $this->description,
            'phone'       => $this->phone,
            'user_id'     => $this->user_id,
        ]);

        $this->clearValidation();
        $this->reset();

        $this->emit('task_updated');
        $this->dispatchBrowserEvent('show-toast', ['message' => 'Task Updated.']);
        $this->dispatchBrowserEvent('close-modal', ['id' => '#ModalEditTask']);
    }
}
