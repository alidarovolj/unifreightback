<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
{

    use Queueable, SerializesModels;
    public $email;
    public $name;
    public $phone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $type, $phone)
    {
        $this->email = $email;
        $this->name = $name;
        $this->phone = $phone;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Заявка с Unifreight')
            ->markdown('emails.messages');
    }
}
