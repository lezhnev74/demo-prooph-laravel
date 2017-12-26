<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 20/12/2017
 */

namespace App\Component\Account\Command\RequestAccountWithEmail;


use App\Component\Account\Event\AccountRequested;
use App\Component\Account\Mailable\AccountEmailVerificationSent;

class RequestAccountWithEmailHandler
{
    function __invoke(RequestAccountWithEmail $command)
    {
        $code = \Hash::make($command->getEmail());
        \Mail::to($command->getEmail())->queue(new AccountEmailVerificationSent($code, $command->getEmail()));
        event(new AccountRequested($command->getEmail()));
    }
}