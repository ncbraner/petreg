<?php

namespace App\Listeners;

use App\Events\PetRegistrationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class PetRegistrationEventListener
{
    /**
     * Handle the event.
     *
     * @param PetRegistrationEvent $event
     * @return void
     */
    public function handle(PetRegistrationEvent $event): void
    {
        // Bust the cache when a pet registration is created
        Cache::forget("petRegistrations.{$event->petRegistration->user_id}");
    }
}
