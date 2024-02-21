<?php
namespace App\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

class TwilioChannel
{
    public function send($notifiable, Notification $notification)
    {
        $twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));

        try {
            $message = $twilio->messages->create(
                   $notifiable->routeNotificationFor('twilio'), // Phone number of the recipient
                [
                    'from' => env('TWILIO_PHONE_NUMBER'), // Your Twilio phone number
                    'body' => $notification->toTwilio($notifiable), // Body of the SMS notification
                ]
            );

            // If the message was sent successfully, return true
            return true;

        } catch (TwilioException $e) {
            // Log the error or handle it as desired
            // You can also return false here to indicate that sending failed
            return false;
        }
    }
}
