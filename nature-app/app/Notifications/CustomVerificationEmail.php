<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class CustomVerificationEmail extends VerifyEmailNotification
{
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email - Nature') // ✨ Your subject
            ->greeting('Hello ' . $notifiable->name . ',') // ✨ Custom greeting
            ->line('Thank you for registering at Nature.') // ✨ Custom text
            ->line('Please click the button below to verify your email:')
            ->action('Verify Email', $verificationUrl)
            ->line('If you did not create an account, no action is required.')
            ->salutation('Regards, Nature Team'); // ✨ Custom footer
    }

    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(60),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }
}
