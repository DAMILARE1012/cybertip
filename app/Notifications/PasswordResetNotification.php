<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;
    protected $notification_url;
    protected $user;
    /**
     * Create a new notification_url instance.
     *
     * @param $notification_url
     */
    public function __construct($notification_url, $user)
    {
        $this->notification_url = $notification_url;
        $this->user = $user;
    }
    /**
     * Get the notification_url's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
    /**
     * Get the mail representation of the notification_url.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting("Greetings! {$this->user->name}")
            ->line("This is to inform you that your account registration has been successfully approved by CyberPlural. :)")
            ->line("Your registration details includes the following: ")
            ->line("Email Address: {$this->user->email}")
            ->line("Company Name: {$this->user->companyName}")
            ->line('Kindly perfect your profile creation using the link below')
            ->action('Set Password', $this->notification_url)
            ->line('We look forward to seeing you on the platform.')
            ->line('Thank you and best regards.');
    }
    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
