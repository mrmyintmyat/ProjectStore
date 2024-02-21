<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Session;

class VerifyEmailNotification extends VerifyEmailBase
{
    /**
     * Get the mail representation of the notification.
     */

    public function toMail($notifiable)
    {
        $verificationCode = mt_rand(100000, 999999);
        Session::put('verification_email_code', $verificationCode);

        return (new MailMessage)
            ->subject("Email verification code: $verificationCode")
            ->markdown("auth.mail_style.email", ["verificationCode" => $verificationCode]);
    }

}
