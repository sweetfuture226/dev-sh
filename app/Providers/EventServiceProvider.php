<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ContractCreatedEvent;
use App\Events\ParticipantStatusChanged;
use App\Events\ContractStatusChanged;
use App\Listeners\PushContractToChat;
use App\Listeners\SendContractEmail;
use App\Listeners\PushedMemberStatus;
use App\Listeners\PushContractStatusToChat;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ContractCreatedEvent::class => [
          PushContractToChat::class,
          SendContractEmail::class
        ],
        ParticipantStatusChanged::class => [
          PushedMemberStatus::class
        ],
        ContractStatusChanged::class => [
          PushContractStatusToChat::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
