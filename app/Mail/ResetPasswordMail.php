<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->subject('Redefinição de Senha 🔑');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reset')
        ->with([
            'user'=> $this->user,
            'url' => $this->resetUrl()
        ]);
    }

    protected function resetUrl()
    {
        return url(route('password.reset', [
            'token' => $this->token,
            'email' => $this->user->email,
        ], false));
    }
}
