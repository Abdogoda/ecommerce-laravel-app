<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileReqeust;
use App\Http\Requests\PasswordRequiredRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateProfileController extends Controller{
    
    public function update(UpdateProfileReqeust $request){
        $user = User::find(Auth::id());
        $validated = $request->validated();

        if($request->has('email') && $request->email !== $user->email){
            $validated['email_verified_at'] = null;
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully');
    }

    public function destroy(PasswordRequiredRequest $request){
        $user = User::find(Auth::id());
        
        Auth::logout();
        $user->delete();
        return redirect()->to('/')->with('success', 'Your account has been deleted');
    }
}