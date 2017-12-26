<?php

namespace App\Component\Account\Event;

use App\Component\Foundation\MessageBus\SerializableMessage;

class AccountRequested extends SerializableMessage
{
    public function __construct(string $email)
    {
        parent::__construct([
            'email' => $email
        ]);
    }


    function getEmail(): string
    {
        return $this->payload['email'];
    }
}
