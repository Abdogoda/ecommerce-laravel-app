<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller{

    public function __invoke(RegisterRequest $request){
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        // TODO: Send OTP to email for verification
        // Mail::to($user->email)->send(new VerifyAccountMail($user->otp, $user->email));

        return redirect()->route('email.verify', $user->email)->with('success', 'Registration successful! Please verify your email.');
    }
}