<?php

namespace App\Console\Commands;

use App\Mail\EmailRegisteredUsers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisteredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'register:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail with the number of registered users';

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
        //Total user registered today
        $count = DB::table('users')->whereRaw('Date(created_at) = CURDATE()')->count();

        $notificationRegisteredUser = new EmailRegisteredUsers($count);

        //Send email with the total users registered.
        Mail::to('em@admin.com')->send($notificationRegisteredUser);
    }
}
