<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Session;

class SMSNotification extends Notification
{
    protected $verificationCode;
    protected $isPasswordReset;

    public function __construct($verificationCode, $isPasswordReset = false)
    {
        $this->verificationCode = $verificationCode;
        $this->isPasswordReset = $isPasswordReset;
    }

    public function via($notifiable)
    {
        return ['twilio'];
    }

    public function toTwilio($notifiable)
    {
        $message = $this->isPasswordReset ? 'Password reset code' : 'Verification code';
        $message .= ": {$this->verificationCode}";

        Session::put('verification_code', $this->verificationCode);

        return $message;
    }
}
