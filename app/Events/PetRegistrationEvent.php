<?php

namespace App\Events;

use App\Models\PetRegistration;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PetRegistrationEvent
{
    use Dispatchable, SerializesModels;

    public $petRegistration;

    public function __construct(PetRegistration $petRegistration)
    {
        $this->petRegistration = $petRegistration;
    }
}
