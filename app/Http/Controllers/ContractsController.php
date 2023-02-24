<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use App\Models\Contract;
use App\Events\ParticipantStatusChanged;
use App\Events\ContractStatusChanged;

class ContractsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Task $task)
    {
        if (auth()->user()->cannot('create', Contract::class)) {
            abort(403);
        }

        if ($task->contract and $task->contract->status != 'rejected') {
          return redirect()->back()->withError("Contract Already created");
        }

        $users = User::where('role', 'user')->get();

        return view('contracts.add', compact('task', 'users'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Task $task, Contract $contract)
    {
      $user = auth()->user();
      if ($user->cannot('view', $contract)) {
          abort(403);
      }
      $current_participant = $contract->participants->where('id', $user->id)->first();
      $active_mileston = $contract->milestones()->where('status', 'active')->first();
      return view('contracts.show', compact('contract', 'current_participant', 'active_mileston'));
    }

    public function update(Request $request, Task $task, Contract $contract)
    {
      $user = auth()->user();
      if ($user->cannot('update', $contract)) {
          abort(403);
      }
      $status = $request->has('accept') ? Contract::ACCEPTED : Contract::REJECTED;
      $contract->participants()->updateExistingPivot($user->id, ['status' => $status]);
      $still_pending = $contract->participants()->where('contract_participants.status', 'pending')->count() > 0;
      $rejected = $contract->participants()->where('contract_participants.status', Contract::REJECTED)->count() > 0;
      if ($rejected) {
        $contract_status = Contract::REJECTED;
      } else {
        $contract_status = $still_pending ? Contract::PARTIAL_ACCEPTED : Contract::ACCEPTED;
      }

      $contract->update(['status' => $contract_status]);
      event(new ParticipantStatusChanged($contract, $status, auth()->user()));
      return redirect()->back();
    }

    public function start(Request $request, Contract $contract)
    {
      $user = auth()->user();
      $current_participant = $contract->participants->where('id', $user->id)->first();
      if ($user->role != 'coordinator' ||  $contract->status != Contract::ACCEPTED) {
          abort(403);
      }
      $status = Contract::STARTED;
      $contract->update(['status' => $status]);
      $first_mileston = $contract->milestones()->first();
      if ($first_mileston) {
        $first_mileston->update(['status' => 'active']);
      }

      event(new ContractStatusChanged($contract, $status, auth()->user()));
      return redirect()->back();
    }

    public function pay(Request $request, Contract $contract)
    {
      $user = auth()->user();
      $current_participant = $contract->participants->where('id', $user->id)->first();
      if ($user->id != $contract->task->user_id ||  $contract->status != Contract::STARTED) {
          abort(403);
      }
      $should_end = true;
      if ($contract->milestones->count() > 0) {
        $active_mileston = $contract->milestones()->where('status', 'active')->first();
        $active_mileston->update(['status' => 'paid']);
        $first_pending = $contract->milestones()->where('status', 'pending')->first();
        if ($first_pending) {
          $first_pending->update(['status' => 'active']);
          $should_end = false;
        }
      }
      if ($should_end) {
        $status = Contract::FINISHED;
        $contract->update(['status' => $status]);
        event(new ContractStatusChanged($contract, $status, auth()->user()));
      }

      return redirect()->back();
    }
}
