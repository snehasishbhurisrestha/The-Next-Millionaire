<?php

namespace App\Http\Controllers\Site\UserDashboard;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('site.user-dashboard.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        // $user->email = $request->email;
        $user->phone = $request->phone;

        if($request->password){
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success','Profile updated successfully');
    }
}
