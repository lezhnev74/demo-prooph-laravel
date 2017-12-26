<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/12/2017
 */

namespace App\Component\Account\Command\CreateAccountFromRequest;


use App\Component\Account\Mailable\AccountWelcomeEmailSent;
use App\Component\Account\Model\Account;
use App\Components\Account\Events\AccountCreated;

class CreateAccountFromRequestHandler
{
    function __invoke(CreateAccountFromRequest $command)
    {
        if (!\Hash::check($command->getEmail(), $command->getCode())) {
            throw new \DomainException("Verification code is invalid");
        }

        if (Account::where('email', $command->getEmail())->count()) {
            throw new \DomainException("Account exists already");
        }

        $model = Account::create([
            'email' => $command->getEmail(),
            'password' => password_hash($command->getPassword(), PASSWORD_DEFAULT),
            'remember_token' => str_random(100)
        ]);

        \Mail::to($model->email)->send(new AccountWelcomeEmailSent());
        event(new AccountCreated($model->id, $model->email));

    }
}