<?php

namespace App\Models\front;

use App\Models\admin\Plan;
use App\Models\admin\Platform;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'transaction_id', 'plan_id', 'plan_price', 'order_id', 'order_description',
        'payment_status', 'payment_id', 'original_price', 'amount_received','platform_id'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
