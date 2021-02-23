<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Messages\BroadcastMessage;

class HasMatched extends Notification
{
    use Queueable;

    public $user;
    public $read_at;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $read_at)
    {
        $this->user = $user;
        $this->read_at = $read_at;
        
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user' => $this->user,
            'read_at' => $this->read_at,
        ];
    }

    public function toBroadcast($notifiable)
{
    return new BroadcastMessage([
        'id' => $this->id,
        'user' => [
            $this->user,
        ]
    ]);
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
            //
        ];
    }
}
