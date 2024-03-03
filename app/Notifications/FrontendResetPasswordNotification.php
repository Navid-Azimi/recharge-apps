<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FrontendResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $resetLink;

    public function __construct($resetLink)
    {
        $this->resetLink = $resetLink;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
             ->action('Reset Password', url("{$this->resetLink}&email=" . urlencode($notifiable->getEmailForPasswordReset())))
            ->line('If you did not request a password reset, no further action is required.');
    }
}
