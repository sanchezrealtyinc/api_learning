<?php

namespace App\Jobs;

use App\Mail\EmailBirthday;
use App\Models\Person;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAllUsersEmailBirthday implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title;
    protected $users;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $users)
    {
        $this->title = $title;
        $this->users = $users;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $currentDate = date('d-m');

        foreach($this->users as $user){
            $person = Person::find($user->person_id);
            $fullName = $person->getFullName();
            
            $birthdayEmail = new EmailBirthday($this->title, $fullName);
            
            $birthday = date('d-m', strtotime($person->birthday));
        
            if($currentDate == $birthday){
                Mail::to($user->email)->send($birthdayEmail);
            }
        }
    }
}
