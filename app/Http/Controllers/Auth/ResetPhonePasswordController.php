<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

class ResetPhonePasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request)
    {
       return view('auth.passwords.phone-reset');
    }

    public function reset(Request $request)
{
    $request->validate([
        'phone' => 'required',
        'password' => 'required|min:8|confirmed',
    ]);

    $phone = Session::get('phone');
    $user = User::where('phone', $phone)->first();
    if (!$user) {
        return 'Error';
    }

    $user->password = Hash::make($request->password);
    $user->setRememberToken(Str::random(60)); // Generate a new remember token
    $user->save();
    
    Session::forget('phone');
    return redirect('/login')->with('success', 'Your password reset was successful. Please log in with your new password.')->with('em_ph', $request->phone);
}


    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}

