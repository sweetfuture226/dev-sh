<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\TaskChat;
use App\Events\NewChatMessageEvent;

class PushContractStatusToChat
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
      TaskChat::create([
        'contract_id' => $contract->id,
        'task_id' => $task->id,
        'from_id' => $user->id,
        'to_id' => $user->id,
        'message' => json_encode([
          'message' => $contract->status_message,
          'action' => "contract_status",
          'color' => $contract->status_color
        ]),
      ]);
      broadcast(new NewChatMessageEvent());
    }
}
