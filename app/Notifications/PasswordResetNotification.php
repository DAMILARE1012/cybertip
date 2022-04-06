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
    /**
     * Create a new notification_url instance.
     *
     * @param $notification_url
     */
    public function __construct($notification_url)
    {
        $this->notification_url = $notification_url;
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
            ->greeting('Greetings!')
            ->line('This is to inform you that your account registration has been successfully approved by CyberPlural. :) ')
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
