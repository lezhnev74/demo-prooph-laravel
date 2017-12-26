<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/12/2017
 */

namespace App\Component\Account\Command\RequestAccountWithEmail;


use App\Component\Foundation\MessageBus\SerializableMessage;
use Assert\Assert;

class RequestAccountWithEmail extends SerializableMessage
{
    public function __construct(string $email)
    {
        Assert::that($email)->email();
        parent::__construct(['email' => $email]);
    }

    function getEmail(): string
    {
        return $this->payload['email'];
    }
}