<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyAccountRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class VerifyAccountController extends Controller{

    public function __invoke(VerifyAccountRequest $request){
        $user = User::where('email', $request->email)->first();
        
        if(!$user->consumeOneTimePassword(implode("", $request->otp))->isOk()){
            return back()->with('error', 'Invalid OTP, please try again.');
        }

        $user->email_verified_at = now();
        $user->save();

        $route = Auth::check() ? 'profile' : 'login';
        return redirect()->route($route)->with('success', 'Email verified successfully, you can login now');
    }
}