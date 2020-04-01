<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMessage extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $message;

    public function __construct(array $data)
    {
        $this->ticket = $data['ticket'];
        $this->message = $data['message'];
    }

    public function build()
    {
        return $this
            ->subject('Новое сообщение')
            ->markdown('emails.new_message');
    }
}
