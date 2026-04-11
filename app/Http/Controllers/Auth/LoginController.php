<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller{

    public function __invoke(LoginRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return back()->with('error', 'Invalid credentials!');
        }

        if(!$user->email_verified_at){
            $user->sendOneTimePassword();
            return redirect()->route('email.verify', $user->email)->with('warning', 'Please verify your email first!');
        }

        Auth::login($user);
        return redirect()->intended(route('home'))->with('success', 'Logged in successfully!');
    }
}