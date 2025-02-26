<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CurrencyInvestment extends Notification
{
    use Queueable;
    protected $user, $user_id, $plan_id, $plan_name, $amount, $currency_number;
    public function __construct($user, $user_id, $plan_id, $plan_name, $amount, $currency_number)
    {
        $this->user = $user;
        $this->user_id = $user_id;
        $this->plan_id = $plan_id;
        $this->plan_name = $plan_name;
        $this->amount = $amount;
        $this->currency_number = $currency_number;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
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
            ->greeting('مرحبا! ' . $this->user->name)
            ->line('تم اضافة استثمار جديد بقيمة ' . $this->amount . ' دولار' . ' لخطة ' . $this->plan_name, )
            ->action('خططي ', url('user/user_plans'))
            ->line(' مرحبا بكم ! ');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user_id,
            'plan_id' => $this->plan_id,
            'plan_name' => $this->plan_name,
            'amount' => $this->amount,
            'currency_number' => $this->currency_number,
            'user' => $this->user,
            'title' => 'تم اضافة استثمار جديد بقيمة ' . $this->amount . ' دولار' . ' لخطة ' . $this->plan_name,
        ];
    }
}
