<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 26/12/2017
 */

namespace Tests\Component\Account\Command\RequestAccountWithEmail;

use Tests\TestCase;
use App\Component\Account\Command\RequestAccountWithEmail\RequestAccountWithEmail;
use App\Component\Account\Event\AccountRequested;
use App\Component\Account\Mailable\AccountEmailVerificationSent;
use Assert\InvalidArgumentException;


class RequestAccountWithEmailHandlerTest extends TestCase
{

    function test_it_can_request_account_from_valid_email()
    {
        \Event::fake();
        \Mail::fake();

        $valid_email = "test@example.org";
        $command = new RequestAccountWithEmail($valid_email);
        \CommandBus::dispatch($command);

        \Event::assertDispatched(AccountRequested::class, function (AccountRequested $e) use ($valid_email) {
            return $e->getEmail() == $valid_email;
        });
        \Mail::assertQueued(AccountEmailVerificationSent::class, function(AccountEmailVerificationSent $mail) use ($valid_email){
            return $mail->hasTo($valid_email);
        });
    }

    function test_it_validates_email()
    {
        $this->expectException(InvalidArgumentException::class);
        $valid_email = "wrong#example.org";
        new RequestAccountWithEmail($valid_email);
    }
}
