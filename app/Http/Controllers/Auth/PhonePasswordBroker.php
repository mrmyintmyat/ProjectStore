<?php
namespace App\Auth;

use Illuminate\Auth\Passwords\PasswordBroker;
use App\Notifications\SMSNotification;
use Illuminate\Support\Facades\Password;

class PhonePasswordBroker extends PasswordBroker
{
    public function sendResetCode(array $credentials)
    {
        $user = $this->getUser($credentials);

        if ($user) {
            $verificationCode = mt_rand(100000, 999999);
            $notification = new SMSNotification($verificationCode);
            $user->notify($notification);
        }
    }
}
