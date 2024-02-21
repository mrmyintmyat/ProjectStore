<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Notifications\SMSNotification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function showPhoneResetForm()
    {
        return view('auth.passwords.phone');
    }

    public function showVerifyForm(Request $request)
    {
        return view('auth.passwords.phone-reset-verify');
    }

    public function sendResetCodeToPhone(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'numeric']
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['phone' => 'User not found']);
        }

        $verificationCode = mt_rand(100000, 999999);
        $notification = new SMSNotification($verificationCode, true); // Indicates a password reset code
        $user->notify($notification);
        Session::put('pasword_reset_code', $verificationCode);
        Session::put('phone', $request->phone);
        return redirect()->route('verify.phone.reset');
        // if ($response) {
        //     return redirect()->route('password.phone.reset', ['token' => $verificationCode])
        //         ->with('status', trans($response));
        // } else {
        //     return redirect()->back()
        //         ->withErrors(['phone' => trans('Failed to send the notification.')])
        //         ->withInput();
        // }
    }

    public function phone_verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_code' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $storedVerificationCode = Session::get('pasword_reset_code');
        $phone = Session::get('phone');

        $enteredVerificationCode = $request->verification_code;

        if ($storedVerificationCode != $enteredVerificationCode) {
            return back()->withErrors(['verification_code' => 'Invalid verification code.'])->withInput();
        }
        Session::forget('pasword_reset_code');
        return redirect()->route('password.phone.reset', ['phone' => $phone]);
    }


}
