<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/12/2017
 */

namespace App\Component\Account\Command\CreateAccountFromRequest;


use App\Component\Foundation\MessageBus\SerializableMessage;

class CreateAccountFromRequest extends SerializableMessage
{
    public function __construct(string $email, string $code, string $password)
    {
        parent::__construct([
            'email' => $email,
            'code' => $code,
            'password' => $password
        ]);
    }

    function getEmail(): string
    {
        return $this->payload['email'];
    }

    function getCode(): string
    {
        return $this->payload['code'];
    }

    function getPassword(): string
    {
        return $this->payload['password'];
    }

}