<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller{
    
    public function logout(Request $request){
        Auth::logout();
        return redirect()->to('/')->with('success', 'You are out');
    }

    public function logoutOtherDevices(Request $request){
        $request->validate([
            'password' => 'required|string',
        ]);

        if (!Auth::validate(['email' => Auth::user()->email, 'password' => $request->password])) {
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }
        
        Auth::logoutOtherDevices($request->password);
        return back()->with('success', 'You are out from other devices');
    }
}