<?php

namespace App\Models\front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'order_id',
        'price_amount',
        'price_currency',
        'invoice_url',
        'status',
        'invoice_id',
        'email',
    ];
}
