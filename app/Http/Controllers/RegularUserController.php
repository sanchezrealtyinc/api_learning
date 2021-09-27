<?php

namespace App\Http\Controllers;

use App\Jobs\SendAllUsersEmailBirthday;
use App\Models\User;

class RegularUserController extends Controller
{
    public function index()
    {
        $title = 'Happy Birthday! May this day be special and live it great. And may your life be long and full of happiness. I wish you the best because you deserve it.';

        SendAllUsersEmailBirthday::dispatch($title, User::regularUser()->get());
        return User::regularUser()->get(); 
    }
}
