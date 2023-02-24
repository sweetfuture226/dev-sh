<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\ContractCreatedEmail;
use Illuminate\Support\Facades\Mail;

class SendContractEmail
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
        $email = $contract->task->email;
        $participant = $contract->participants;
        Mail::to($email)->send(new ContractCreatedEmail($contract));
    }
}
