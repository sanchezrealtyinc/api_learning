<?php

namespace App\Jobs;

use App\Http\Resources\UserResource;
use App\Mail\EmailBirthday;
use App\Models\User;
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
    protected $userId;
    protected $fullName;
    protected $emailUser;
    protected $birthday;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $userId, $emailUser)
    {
        $this->title = $title;
        $this->userId = $userId;
        $this->emailUser = $emailUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = new UserResource(User::find($this->userId));
        $this->fullName = $user->personal_info->first_name . ' ' . $user->personal_info->last_name;

        $birthdayEmail = new EmailBirthday($this->title, $this->fullName);
        
        $this->birthday = $user->personal_info->birthday;

        $isBirthday = Carbon::createFromDate($this->birthday)->isBirthday();
        
        if($isBirthday){
            Mail::to($this->emailUser)->send($birthdayEmail);
        }
        
    }
}
