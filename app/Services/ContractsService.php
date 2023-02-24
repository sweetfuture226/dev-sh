<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\MerchantInterface;
use App\Models\Task;
use App\Models\Contract;
use App\Models\ContractMilestone;
use App\Models\ContractStatusLog;
use App\Events\ContractCreatedEvent;
use DB;

class ContractsService {

  public function create($data, $milestones, $participants)
  {
    if (data_get($data, 'type') != 'task') {
      $data['budget'] = $milestones->sum('budget');
    }
    $data['specialist_id'] = auth()->user()->id;
    $data['status'] = Contract::PENDING;
    $task_id = data_get($data, 'task_id');
    DB::beginTransaction();
    try {
      $contract = Contract::create($data);
      if (data_get($data, 'type') != 'task' and $milestones->count() > 0) {
        $milestones = $milestones->map(function($mileston) {
          $mileston['status'] = ContractMilestone::PENDING;
          return new ContractMilestone($mileston);
        });
        $contract->milestones()->saveMany($milestones);
      }
      $status = ContractStatusLog::create([
        'action_taked_by' => auth()->user()->id,
        'contract_id' => $contract->id,
        'to' => Contract::PENDING
      ]);
      $users = [];
      foreach ($participants as $key => $participant) {
        $users[$participant] = [
          'status' => Contract::PENDING
        ];
      }
      $contract->participants()->sync($users);
      Task::where('id', $task_id)->update(['contract_id' => $contract->id]);
      DB::commit();
      event(new ContractCreatedEvent($contract, $status, auth()->user()));
      return $contract;
    } catch (\Exception $e) {
      DB::rollback();
    }
  }
}
