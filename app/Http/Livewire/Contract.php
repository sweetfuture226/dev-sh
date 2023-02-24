<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Services\ContractsService;
use DB;

class Contract extends Component
{
    public $task;
    public $users;
    public $milestones = [];
    public $type = 'task';
    public $start_at;
    public $duration;
    public $budget;
    public $participants = [];
    public function mount($task, $users)
    {
        $this->task = $task;
        $this->users = $users;
        $this->addNewMileston();
    }

    public function addNewMileston()
    {
      $this->milestones[] = ['name' => '', 'due_to' => '', 'budget' => ''];
    }

    public function removeMilestone($key)
    {
      if (count($this->milestones) > 1) {
        unset($this->milestones[$key]);
      }
    }

    public function save(ContractsService $contractService)
    {
      $this->validate([
        'start_at' => ['required'],
        'duration' => ['required', 'numeric'],
        'budget' => ['required_if:type,task'],
        'milestones' => ['required_if:type,task'],
        'participants' => ['required'],
        'milestones.*.name' => ['required_unless:type,task'],
        'milestones.*.due_to' => ['required_unless:type,task'],
        'milestones.*.budget' => ['required_unless:type,task'],
      ], [],
      ['milestones.*' => 'milestones']);
    //  dd($this->participants);
      $data = [
        'client_id' =>  auth()->user()->id,
        'start_at' =>  $this->start_at,
        'type' =>  $this->type,
        'duration' =>  $this->duration,
        'budget' =>  $this->budget,
        'task_id' =>  $this->task->id
      ];
      $this->participants[] = $this->task->user_id;
      $contractService->create($data, collect($this->milestones), $this->participants);
      return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.contract');
    }
}
