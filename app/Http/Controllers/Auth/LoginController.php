<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller{

    public function __invoke(LoginRequest $request){
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))->with('success', 'Logged in successfully!');
        }
        return redirect()->intended(route('home'))->with('error', 'Invalid credentials!');
    }
}