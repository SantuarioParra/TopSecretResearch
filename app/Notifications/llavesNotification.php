<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class llavesNotification extends Notification
{
    use Queueable;
    private $message;
    private $id_file;
    private $fragment_key;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id_file, $fragment_key, $message)
    {
        $this->id_file = $id_file;
        $this->fragment_key = $fragment_key;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        /*return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');*/
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id_file' => $this->id_file,
            'fragment_key' => $this->fragment_key,
            'message' => $this->message
        ];
    }
}
