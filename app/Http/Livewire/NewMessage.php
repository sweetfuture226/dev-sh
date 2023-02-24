<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Events\NewChatMessageEvent;
use App\Models\User;
use App\Models\TaskChat;
use App\Models\Task;
use App\Models\ChatAttachment;
use Livewire\WithFileUploads;

class NewMessage extends Component
{
    use WithFileUploads;
    public $message = "";
    public $attachments = [];
    public $task;

    public function updatedAttachments()
    {
        $this->validate([
        	'attachments' => ['required'],
          'attachments.*' => ['required', 'mimes:jpeg,jpg,png,pdf', 'max:1024'],
        ], [],
        ['attachments.*' => 'attachments']);
    }

    public function mount($task)
    {
        $this->task = $task;
    }

    public function getListeners()
    {
      return [
        'task.changed'  => 'taskChanged',
        'trix_value_updated'  => 'setMessage'
      ];
    }

    public function setMessage($value){
        $this->message = $value;
    }

    public function taskChanged($task_id)
    {
      $new_task = Task::find($task_id);
      $this->task = $new_task;
      $this->resetForm();
    }

    public function render()
    {
        return view('livewire.new-message');
    }

    public function send()
    {
      if (!empty($this->message)) {
          $toId = auth()->user()->id;
          if (auth()->user()->id == $this->task->user_id) {
              $toId = User::where('is_admin', true)->first()->id;
          } else {
              $toId = $this->task->user_id;
          }
          $taskChat = $this->task->messages()->create([
            'task_id' => $this->task->id,
            'message' => $this->message,
            'from_id' => auth()->user()->id,
            'to_id'   => $toId
          ]);
          $files = [];
          foreach ($this->attachments as $attachment) {
            $file = $attachment->store('attachments');
            $files[] = new ChatAttachment([
              'original_name' => $attachment->getClientOriginalName(),
              'extention' => $attachment->getClientOriginalExtension(),
              'attachment' => $file,
              'task_chat_id' => $taskChat->id
            ]);
          }
          $taskChat->attachments()->saveMany($files);

          $this->emit('message.added', $taskChat->id);
          $this->resetForm();
          $this->dispatchBrowserEvent('clear-trix');
          broadcast(new NewChatMessageEvent());
      }
    }

    public function resetForm()
    {
      $this->message = '';
      $this->attachments = [];
    }
}
