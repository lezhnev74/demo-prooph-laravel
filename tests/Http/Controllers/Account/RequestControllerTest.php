<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 26/12/2017
 */

namespace App\Http\Controllers\Account;


use App\Component\Account\Command\RequestAccountWithEmail\RequestAccountWithEmail;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Prooph\Package\Facades\CommandBus;
use Tests\TestCase;

class RequestControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_guest_can_request_account()
    {
        CommandBus::shouldReceive('dispatch')->withArgs(function ($command) {
            $this->assertTrue($command instanceof RequestAccountWithEmail);
            return true;
        })->once();

        $email = "test@example.org";

        $this
            ->get(route('account.request'))
            ->assertSuccessful();

        $this
            ->post(route('account.request'), [
                'email' => $email
            ])
            ->assertRedirect(route('account.request'))
            ->assertSessionMissing('errors');
    }
}
