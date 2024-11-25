<?php

namespace App\Notifications;

use App\Models\Rent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewRentRequest extends Notification
{
    use Queueable;

    protected $rent;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Rent $rent
     */
    public function __construct(Rent $rent)
    {
        $this->rent = $rent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['database'];
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
            'rent_id' => $this->rent->id,
            'user_id' => $this->rent->user_id,
            'user_name' => $this->rent->user->name,
            'message' => 'telah membuat request baru.',
            'created_at' => $this->rent->created_at->toDateTimeString(),
        ];
    }
}
