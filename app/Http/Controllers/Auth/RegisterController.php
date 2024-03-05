<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Channels\TwilioChannel;
use Illuminate\Validation\Rule;
use App\Helpers\VerificationHelper;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SMSNotification;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Foundation\Auth\RegistersUsers;

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
            'chat_id' => $data['chat_id'],
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'select_chat_id' => ['required'],
            'chat_id' => ['required'], // Ensure chat_id is an array
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Extract chat_id selection and value from the request
        $chatIdSelection = $request->input('select_chat_id');
        $chatIdValue = $request->input('chat_id');

        // Ensure chat_id selection is one of the expected values
        if (!in_array($chatIdSelection, ['messenger', 'telegram', 'skype', 'whatsapp', 'viber'])) {
            return back()->withErrors(['select_chat_id' => 'Invalid chat platform selection'])->withInput();
        }

        // Combine the chat_id selection and value into an associative array
        $chatIdData = [
            $chatIdSelection => $chatIdValue,
        ];

        $serializedChatIdData = json_encode($chatIdData);
        // Additional validation logic if needed...

        // Proceed with user registration
        $user = $this->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'chat_id' => $serializedChatIdData,
        ]);

        Auth::login($user);
        // Handle the rest of the registration process...

        return redirect()->route('email_verify_form')->with('success', 'Please check your email for a verification code.')->with('resendVerification', true);
    }
}
