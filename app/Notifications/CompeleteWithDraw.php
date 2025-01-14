<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompeleteWithDraw extends Notification
{
    use Queueable;

    protected $user_id, $user_name, $amount;
    public function __construct($user_id, $user_name, $amount)
    {
        $this->user_id = $user_id;
        $this->user_name = $user_name;
        $this->amount = $amount;
    }
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject(' اتمام عملية السحب بنجاح  ')
            ->greeting('مرحبا! ' . $this->user_name)
            ->line('تم اتمام عملية السحب بنجاح بقيمة ' . $this->amount . ' دولار')
            ->line(' مرحبا بكم ! ');
    }
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user_id,
            'amount' => $this->amount,
            'user_name' => $this->user_name,
            'title' => 'تم اتمام عملية السحب بنجاح بقيمة ' . $this->amount . ' دولار',
        ];
    }
}
