<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class HolidayNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification_url,$data)
    {
        $this->notification_url = $notification_url;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Dear Management,')
            ->line("This letter is a formal request for a ".$this->data['type'] . " leave from "
                . date("F j, Y",strtotime($this->data['start_date']))
                ." to " . date("F j, Y",strtotime($this->data['end_date'])))
            ->line(ucfirst($this->data['description']) .".")
            ->line('Thank you for reviewing my request!')
            ->action('Approve', $this->notification_url)
            ->salutation("Regards,\r\n". Auth::user()->name);
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
