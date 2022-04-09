<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use app\Role;

class InviteNotification extends Notification
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
            ->greeting("Greetings! {$this->user->email}")
            ->line('This is to invite you to join cybertip intelligence platform. :)')
            ->line("An account has been created for you under ({$this->user->companyName}) with the role: {Role::where('role_id', $this->user->role_id)->first()->role_name}")
            ->line('Kindly click here to accept your membership invitation as a resourceful person')
            ->action('Set Password',$this->notification_url)
            ->line('We humbly look forward to you joining us.')
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
