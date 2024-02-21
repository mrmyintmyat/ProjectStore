<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Response;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    // public function verify(Request $request)
    // {
    //     // Verify the email verification link
    //     $user = User::find($request->id);
    //     return $user;
    //     if (!hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
    //         return Response::json(['error' => 'Invalid verification link'], 403);
    //     }

    //     // Check if the link has expired
    //     $expiresAt = $user->email_verified_at->addMinutes(config('auth.verification.expire'));
    //     if (Carbon::now()->gt($expiresAt)) {
    //         return Response::json(['error' => 'Verification link has expired'], 403);
    //     }

    //     // Mark the user's email as verified
    //     if ($user->markEmailAsVerified()) {
    //         event(new Verified($user));
    //     }

    //     // Redirect the user or show a success message
    //     // ...

    //     return Response::json(['success' => 'Email verified successfully']);
    // }

}
