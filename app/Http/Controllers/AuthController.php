<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendEmailBirthday;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request){
        
        $person = Person::create(
            $request->only(
                'first_name',
                'middle_name', 
                'last_name', 
                'phone_number', 
                'birthday'
            )
        );

        $user = User::create([
            'nickname' => $request->input('nickname'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'person_id' => $person->id,
            'is_admin' => $request->path() === 'api/admin/register' ? 1 : 0
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request){
        if(!Auth::attempt($request->only('email', 'password'))){
            return response([
                'error' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::where('email', $request->input('email'))->firstOrFail();

        $adminLogin = $request->path() == 'api/admin/login';

        if($adminLogin && !$user->is_admin){
            return response([
                'error'=> 'Access Denied'
            ],Response::HTTP_UNAUTHORIZED);
        }

        $scope = $adminLogin ? 'admin' : 'regularUser';
        $jwt = $user->createToken('token', [$scope])->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60*24); //60min->1 hour * 24 hours = 1 day

        return response([
            'message' => 'Authenticate successfuly'
        ])->withCookie($cookie);
    }

    public function user(Request $request){
        //Jobs for notification birthday user
        SendEmailBirthday::dispatch(
            'Feliz cumpleaños',
            $request->user()->person_id,  
            $request->user()->email
        );
        
        $user = $request->user();
            
        return new UserResource($user);
    }

    public function logout(){
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'Logout succesfully'
        ])->withCookie($cookie);
    }

    public function updateProfile(Request $request){
        $user = $request->user();
        
        $person = Person::find($user->person_id);

        $user->update($request->only('nickname', 'email'));

        $person->update($request->only(
            'first_name',
            'middle_name', 
            'last_name', 
            'phone_number', 
            'birthday'
        ));

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function updatePassword(Request $request){
        $user = $request->user();

        $user->update([
            'password'=> Hash::make($request->input('password'))
        ]);

        return response($user, Response::HTTP_ACCEPTED);
    }
}
