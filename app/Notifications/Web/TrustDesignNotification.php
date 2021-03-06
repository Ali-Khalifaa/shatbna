<?php

namespace App\Notifications\Web;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TrustDesignNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
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
            'company_id' => $this->user->id,
            'image' => $this->user->media->file_name,
            'timeDate' => now()->format('jS \of F  h:i'),
            'name' => 'trustDesgin'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => [
                'company_id' => $this->user->id,
                'image' => $this->user->media->file_name,
                'timeDate' => now()->format('jS \of F  h:i'),
                'name' => 'trustDesgin'
            ]
        ]);
    }
}
