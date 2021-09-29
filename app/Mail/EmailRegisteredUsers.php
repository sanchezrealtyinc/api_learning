<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailRegisteredUsers extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $count;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($count)
    {
        $this->count = $count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.registeredcount');
    }
}
