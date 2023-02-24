<?php

namespace App\Http\Livewire\Admin\Tasks;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class TasksList extends Component
{
    use WithPagination;

    public function render()
    {
        $tasks = Task::query()
            ->with('user')
            ->paginate(10);

        return view('livewire.admin.tasks.tasks-list', compact('tasks'));
    }

    protected $listeners = [
        'task_added'   => '$refresh',
        'task_updated' => '$refresh',
    ];

    public function delete_task($id)
    {
        if ($task = Task::find($id)) {
            $task->delete();

            $this->dispatchBrowserEvent('show-toast', ['message' => 'Task deleted.']);
        }
    }

    public function delete_selected_tasks($ids)
    {
        if ($tasks = Task::query()->whereIn('id', $ids)->get()) {
            foreach ($tasks as $task) {
                $task->delete();
            }

            $this->dispatchBrowserEvent('show-toast', ['message' => 'Tasks deleted.']);
        }
    }

}
