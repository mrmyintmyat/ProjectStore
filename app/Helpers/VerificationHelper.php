<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

class VerificationHelper
{
    public static function verifyEmailCode($verificationCode)
    {
        // Find the user by ID
        $user = Auth::user();
        if (!$user) {
            return false;
        }

        $storedVerificationCode = Session::get('verification_email_code');

        if ($storedVerificationCode != $verificationCode) {
            return false;
        }

        // Mark the email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Clear the session data
        Session::forget('id');
        Session::forget('verification_email_code');

        return true;
    }

    public function verifyPhoneCode($id, $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_code' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $storedVerificationCode = Session::get('verification_code');
        $enteredVerificationCode = $request->verification_code;

        if ($storedVerificationCode != $enteredVerificationCode) {
            return false;
        }

        // Retrieve the name, identifier, and password from the session
        // $name = Session::get('name');
        $identifier = Session::get('identifier');
        // $password = Session::get('password');

        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL);

        $id = Session::get('id');

        // Find the user by ID
        $user = Auth::user();
        if (!$user) {
            return back();
        }
        // Fire the Registered event
        event(new Registered($user));

        // Clear the stored verification code and session data
        Session::forget('id');
        Session::forget('verification_code');
        Session::forget('name');
        Session::forget('identifier');
        Session::forget('password');
        $user->phone_verified_at = now();
        $user->save();

        return true;
    }

}
