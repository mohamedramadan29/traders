<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ChargeBalance extends Notification
{
    use Queueable;

    protected $user;
    protected $user_id;
    protected $charge_balance;
    protected $created_at;

    public function __construct($user, $user_id, $charge_balance, $created_at)
    {
        $this->user = $user;
        $this->user_id = $user_id;
        $this->charge_balance = $charge_balance;
        $this->created_at = $created_at;
    }
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('اضافة رصيد جديد')
            ->greeting('اضافة رصيد جديد')
            ->line('تم شحن الرصيد الخاص بك بقيمة ' . $this->charge_balance . 'دولار ')
            ->action('حسابي', url('user/profile'))
            ->line(' مرحبا بكم ! ');
    }
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user_id,
            'charge_balance' => $this->charge_balance,
            'created_at' => $this->created_at,
            'user' => $this->user,
            'title' => ' تم اضافة رصيد جديد',
        ];
    }
}
