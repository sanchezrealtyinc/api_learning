<?php

namespace App\Jobs;

use App\Mail\EmailBirthday;
use App\Models\Person;
use Illuminate\Bus\Queueable;
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
        $fullName = $user->getFullName();
        $birthdayEmail = new EmailBirthday($this->title, $fullName);
        
        $this->birthday = $user->birthday;
        
        /*
        Procesamiento de fechas con carbon
        $currentDate = Carbon::now();
        $birthday = Carbon::createFromDate(date(($this->birthday)));

        condicion: if($currentDate->day===$birthday->day && $currentDate->month===$birthday->month) 
        */
        
        $currentDate = date('d-m');
        $birthday = date('d-m', strtotime($this->birthday));
        
        if($currentDate == $birthday){
            Mail::to($this->emailUser)->send($birthdayEmail);
        }
        
    }
}
