<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    private $studentFullName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $id, string $name)
    {
        $this->user = User::findOrFail($id);
        $this->studentFullName = $name;
        $this->subject('Seja bem vindo(a)! 🥳');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.welcome')
            ->with([
                'nome'  => $this->user->formatted_name,
                'email' => $this->user->email,
                'password' => Crypt::decryptString($this->user->password),
                'filho' => $this->studentFullName
            ]);
    }
}
