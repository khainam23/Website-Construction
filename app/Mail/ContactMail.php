<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{

    public $name;
    public $phone;
    public $description;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $phone, $description)
    {
        $this->name = $name;
        $this->phone = $phone;
        $this->description = $description;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'))
            ->subject('[Cần hỗ trợ] ' . $this->name)
            ->view('frontend.contact-form')
            ->with([
                'name'=> $this->name,
                'phone'=> $this->phone,
                'description'=> $this->description
            ]);
    }
}
