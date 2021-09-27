<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailBirthday extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Happy BirthDay, ';
    protected $title;
    protected $fullName;
    protected $user; 
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $user)
    {
        $this->title = $title;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->fullName = $this->user->first_name . ' ' . $this->user->last_name;

        return $this->from('em@leader.com', 'Em Leader')
                    ->subject($this->subject . ' ' . $this->fullName )
                    ->view('emails.emailbirthday')
                    ->with([
                        'title' => $this->title
                    ]);
    }
}
