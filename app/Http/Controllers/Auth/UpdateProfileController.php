<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileReqeust;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function destroy(Request $request){
        $user = User::find(Auth::id());

        $request->validate([
            'password' => 'required|string',
        ]);

        if(!Auth::validate(['email' => $user->email, 'password' => $request->password])){
            return back()->withErrors(['password' => 'The provided password does not match our records.']);
        }

        Auth::logout();
        $user->delete();
        return redirect()->to('/')->with('success', 'Your account has been deleted');
    }
}