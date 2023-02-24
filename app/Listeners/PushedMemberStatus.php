<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Contract;
use App\Models\TaskChat;
use App\Events\NewChatMessageEvent;

class PushedMemberStatus
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
      $contract = $event->contract;
      $task = $event->contract->task;
      $status = $event->status;
      $user = $event->sender;
      $color = $status == Contract::ACCEPTED ? 'green' : 'red';
      $message = $status == Contract::ACCEPTED ? "accept contract" : "reject contract";
      $message = $user->name." ".$message;
      TaskChat::create([
        'contract_id' => $contract->id,
        'task_id' => $task->id,
        'from_id' => $user->id,
        'to_id' => $user->id,
        'message' => json_encode([
          'message' => "Review Contract",
          'action' => "member_status",
          'sub_message' => $message,
          'color' => 'orange',
          'sub_color' => $color
        ]),
      ]);
      broadcast(new NewChatMessageEvent());
    }
}
