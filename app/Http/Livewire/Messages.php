<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskChat;
use App\Models\Task;

class Messages extends Component
{
    public $messages;
    public function mount($messages){
      $this->messages = $messages;
    }

    public function getListeners()
    {
      return [
        'message.added' => 'appendMessage',
        'task.changed'  => 'taskChanged'
      ];
    }

    public function appendMessage($message_id)
    {
      $message = TaskChat::find($message_id);
      $message->load('attachments');
      $this->messages->push($message);
      $this->dispatchBrowserEvent('new-text');
    }

    public function taskChanged($task_id)
    {
      $new_task = Task::with('messages')->where('id', $task_id)->first();
      $this->messages = $new_task->messages;
      //$this->dispatchBrowserEvent('taskSelected');
      $this->dispatchBrowserEvent('new-text');
    }

    public function render()
    {
        return view('livewire.messages');
    }
}
