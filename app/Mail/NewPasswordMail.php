<?php

namespace App\Mail;
use Illuminate\Mail\Mailable;

class NewPasswordMail extends Mailable
{
    public $password;

    public function __construct($password)
    {
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Mật khẩu mới của bạn')
            ->view('frontend.new-password')
            ->with(['password' => $this->password]);
    }
}
