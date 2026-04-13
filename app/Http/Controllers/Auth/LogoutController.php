<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequiredRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller{
    
    public function logout(Request $request){
        Auth::logout();
        return redirect()->to('/')->with('success', 'You are out');
    }

    public function logoutOtherDevices(PasswordRequiredRequest $request){
        DB::table('sessions')
            ->where('user_id', $request->user()->id)
            ->where('id', '!=', session()->getId())
            ->delete();
        
        return back()->with('success', 'You are out from other devices');
    }
}