<?php
/**
 * @author Dmitriy Lezhnev <lezhnev.work@gmail.com>
 */
declare(strict_types=1);

namespace App\Component\Account\Mailable;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

final class AccountEmailVerificationSent extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $secret_code;
    public $email;

    /**
     * AccountEmailVerificationSent constructor.
     * @param $secret_code
     * @param $email
     */
    public function __construct($secret_code, $email)
    {
        $this->secret_code = $secret_code;
        $this->email = $email;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Verify your email")
            ->markdown('mail.account.email_verification_link.md', [
                'link' => route('account.request.verify_email', ['email' => $this->email, 'code' => $this->secret_code])
            ]);
    }
}