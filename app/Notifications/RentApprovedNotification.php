<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\Rent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RentApprovedNotification extends Notification
{
    use Queueable;

    protected $rent;

    /**
     * Create a new notification instance.
     */
    public function __construct(Rent $rent)
    {
        $this->rent = $rent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'rent_id' => $this->rent->id,
            'user_id' => $this->rent->user_id,
            'user_name' => $this->rent->user->name,
            'message' => 'Your rent request has been approved.',
            'created_at' => now()->toDateTimeString(),
        ];
    }
}
