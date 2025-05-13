<?php

namespace App\Models\front;

use App\Models\admin\CurrencyPlan;
use App\Models\front\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sitecomssion extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency_plan_id',
        'user_id',
        'amount',
        'created_at',
        'updated_at',
    ];
    public function currencyPlan()
    {
        return $this->belongsTo(CurrencyPlan::class, 'currency_plan_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
