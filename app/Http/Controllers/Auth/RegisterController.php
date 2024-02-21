<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Verified;
use App\Notifications\SMSNotification;
use App\Helpers\VerificationHelper;
use App\Channels\TwilioChannel;
class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:14'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:14'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $isEmail = filter_var($request->email, FILTER_VALIDATE_EMAIL);

        if ($isEmail) {

        $emailExists = User::where('email', $request->email)->exists();
        if ($emailExists) {
            $errorMessage = 'The email is already registered. Please choose a different email.';
            return back()->withErrors(['email' => $errorMessage]);
        }

            $user = $this->create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            Session::put('id', $user->id);

            event(new Registered($user));
            $this->guard()->login($user);

            return redirect()->route('email_verify_form')
                ->with('success', 'Please check your email for a verification code.')
                ->with('resendVerification', true);

        }
    }
}
