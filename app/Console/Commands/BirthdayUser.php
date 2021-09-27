<?php

namespace App\Console\Commands;

use App\Http\Resources\UserResource;
use App\Mail\EmailBirthday;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BirthdayUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'birthday:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email to users for their birthday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $i = 0;
        $currentDate = Carbon::now();
        $users = DB::table('people')->whereDay('birthday', $currentDate->day)->whereMonth('birthday', $currentDate->month)->get();
        
        foreach($users as $user){
            
            $title = 'Happy Birthday! May this day be special and live it great. And may your life be long and full of happiness. I wish you the best because you deserve it.';
            $birthdayEmail = new EmailBirthday($title, $user);
            Mail::to('em@admin.com')->send($birthdayEmail);
            $i++;
        }
        $this->info($i . ' Birthday messages sent successfully');
    }
}
