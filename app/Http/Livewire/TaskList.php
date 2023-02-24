<?php

namespace App\Http\Livewire;

use App\Events\NewChatMessageEvent;
use App\Models\Task;
use App\Models\TaskChat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;
use Livewire\Component;

class TaskList extends Component
{
    public $tasks = [];
    public $selectedTask = null;
    public $conversations = [];
    public $message = '';
    public $taskObject = null;
    public $agent = '';

    public function render()
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            $this->agent = 'Mobile';
        } else {
            $this->agent = 'Other';
        }

        $user = auth()->user();
        $this->tasks = Task::when(!Auth::user()->is_admin and Auth::user()->role != 'coordinator', function ($query) use($user){
            $query->where('user_id', Auth::id());
            $query->orWhere( function($q) use($user) {
              $q->whereHas('contract.participants', function($q) use($user){
                $q->where('users.id', $user->id);
              });
            });
        })->with('contract', 'messages', 'messages.attachments')
        ->orderBy('created_at', 'desc')->get();

        if (!$this->selectedTask && $this->tasks->count() > 0) {
            $this->taskObject = $this->tasks->first();
            $this->selectedTask = data_get($this->taskObject, 'id');
            $this->conversations = $this->taskObject->messages;
        }
        return view('livewire.task-list');
    }

    public function selectTask($id)
    {
    	$this->conversations = collect();
        $this->selectedTask = $id;
        $this->taskObject = Task::find($id);
        $this->emit('task.changed', $this->taskObject->id);
        $this->dispatchBrowserEvent('taskSelected');
        $this->dispatchBrowserEvent('clear-trix');
        //$this->dispatchBrowserEvent('new-text');
    }

    public function checkTask($id)
    {
    	$this->conversations = collect();
        $this->selectedTask = $id;
        $this->taskObject = Task::find($id);
        $this->emit('task.changed', $this->taskObject->id);
    }

    public function refreshChat()
    {
    	$this->conversations = collect();
        if ($this->selectedTask) {
            $this->emit('task.changed', $this->taskObject->id);
	          $this->dispatchBrowserEvent('new-text');
        }
    }

    public function deleteTask($id)
    {
        $task = Task::where('id', $id)->first();
        Task::where('id', $id)->delete();

        // Remove attached file if exist
        if ($task->file) {
            if (Storage::exists($task->file)) {
                Storage::delete($task->file);
            }
        }

        $this->selectedTask = null;
        $this->taskObject = null;
    }
}
