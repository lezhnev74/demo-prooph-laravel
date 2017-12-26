<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 26/12/2017
 */

namespace Tests\Component\Account\Command\CreateAccountFromRequest;

use App\Component\Account\Command\CreateAccountFromRequest\CreateAccountFromRequest;
use App\Component\Account\Mailable\AccountWelcomeEmailSent;
use App\Components\Account\Events\AccountCreated;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Prooph\ServiceBus\Exception\CommandDispatchException;
use Tests\TestCase;

class CreateAccountFromRequestHandlerTest extends TestCase
{
    use DatabaseMigrations;

    function test_account_is_created_from_email_and_verification_code()
    {
        \Event::fake();
        \Mail::fake();

        $email = "some2@example.org";
        $code = \Hash::make($email);
        $password = "123456";

        \CommandBus::dispatch(new CreateAccountFromRequest($email, $code, $password));

        \Event::assertDispatched(AccountCreated::class, function (AccountCreated $e) use ($email) {
            return $e->getPayload()['email'] == $email;
        });
        \Mail::assertQueued(AccountWelcomeEmailSent::class);
    }

    function test_it_validates_the_code()
    {
        $email = "some@example.org";
        $wrong_code = "aaaaaaa";
        $password = "123321";

        try {
            \CommandBus::dispatch(new CreateAccountFromRequest($email, $wrong_code, $password));
        } catch (CommandDispatchException $e) {
            $this->assertTrue($e->getPrevious() instanceof \DomainException);
        }
    }

}
