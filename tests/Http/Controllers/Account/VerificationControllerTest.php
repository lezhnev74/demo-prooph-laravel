<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 * Date: 26/12/2017
 */

namespace App\Http\Controllers\Account;


use App\Component\Account\Model\Account;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Prooph\ServiceBus\Exception\CommandDispatchException;
use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
    use DatabaseMigrations;

    function test_user_can_create_account_after_opening_email_link()
    {
        $email = "valid@example.org";
        $code = \Hash::make($email);
        $password = "good_password";

        $this
            ->get(route('account.request.verify_email', [
                'email' => $email,
                'code' => $code
            ]))
            ->assertSuccessful();

        $this
            ->post(route('account.request.verify_email'), [
                'email' => $email,
                'code' => $code,
                'password' => $password,
                'password_confirmation' => $password,
            ])
            ->assertSessionMissing('errors');

        $this->assertNotNull(Account::where('email', $email)->first());
    }

    function test_user_sees_error_if_revisits_the_same_link()
    {
        $account = factory(Account::class)->create();
        $code = \Hash::make($account->email);
        $password = "123456";

        $this
            ->post(route('account.request.verify_email'), [
                'email' => $account->email,
                'code' => $code,
                'password' => $password,
                'password_confirmation' => $password,
            ])
            ->assertStatus(500);
    }
}
