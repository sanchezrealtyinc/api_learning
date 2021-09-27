<?php

namespace App\Jobs;

use App\Http\Resources\UserResource;
use App\Mail\EmailBirthday;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailBirthday implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $personId;
    protected $fullName;
    protected $emailUser;
    protected $birthday;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $personId, $emailUser)
    {
        $this->title = $title;
        $this->personId = $personId;
        $this->emailUser = $emailUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = Person::find($this->personId);
        
        $birthdayEmail = new EmailBirthday($this->title, $user);
        
        $this->birthday = $user->birthday;
        
        $isBirthday = Carbon::createFromDate($this->birthday)->isBirthday();

        if($isBirthday){
            Mail::to($this->emailUser)->send($birthdayEmail);
        }
        
    }
}
