<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StorageInvestMentNotification extends Notification
{
    use Queueable;

    protected $user_id, $user_name, $amount, $duration;
    public function __construct($user_id, $user_name, $amount, $duration)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->amount = $amount;
        $this->$duration = $duration;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(' اضافة استثمار جديد')
            ->greeting('مرحبا! ' . $this->user_name)
            ->line('تم اضافة استثمار جديد بقيمة ' . $this->amount . ' دولار' . ' لخطة ' . $this->duration . ' يوم', )
            ->action('الاستثمارت ', url('user/storage'))
            ->line(' مرحبا بكم ! ');
    }
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'amount' => $this->amount,
            'dura$duration' => $this->duration,
            'title' => 'تم اضافة استثمار جديد بقيمة ' . $this->amount . ' دولار' . ' لخطة ' . $this->duration . ' يوم',
        ];
    }
}
