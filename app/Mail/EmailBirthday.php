<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBirthday extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = 'Happy BirthDay, ';
    protected $title;
    protected $fullName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $fullName)
    {
        $this->title = $title;
        $this->fullName = $fullName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('em@leader.com', 'Em Leader')
                    ->subject($this->subject . ' ' . $this->fullName )
                    ->view('emails.emailbirthday')
                    ->with([
                        'title' => $this->title
                    ]);
    }
}
