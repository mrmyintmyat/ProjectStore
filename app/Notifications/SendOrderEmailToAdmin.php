<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Session;

class SendOrderEmailToAdmin extends VerifyEmailBase
{
    /**
     * Get the mail representation of the notification.
     */
    protected $order;
    protected $emailuser;

    public function __construct($order, $emailuser)
    {
        $this->order = $order;
        $this->emailuser = $emailuser;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("You have a new order!")
            ->markdown('auth.mail_style.email-order', ['order' => $this->order, 'user' => $this->emailuser]);
    }

    protected function orderMail($notifiable)
    {

    }
}
