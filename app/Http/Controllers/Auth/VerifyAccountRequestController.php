<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyAccountRequestController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        if(!$user->email_verified_at){
            $user->sendOneTimePassword();
            return redirect()->route('email.verify', $user->email)->with('success', 'Verification email sent successfully!');
        }else{
            return redirect()->route('profile')->with('info', 'Your email is already verified!');
        }
    }
}