<?php

namespace App\Components\Account\Events;

use App\Component\Foundation\MessageBus\SerializableMessage;

class AccountCreated extends SerializableMessage
{
    public function __construct(int $id, string $email)
    {
        parent::__construct([
            'id' => $id,
            'email' => $email,
        ]);
    }


    function getEmail(): string
    {
        return $this->payload['email'];
    }

    function getId(): int
    {
        return $this->payload['id'];
    }
}
