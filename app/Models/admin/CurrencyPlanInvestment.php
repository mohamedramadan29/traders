<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyPlanInvestment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'currency_plan',
        'user_id',
        'total_investment',
        'currency_number',
        'currency_price',
    ];

    public function CurrencyPlan()
    {
        return $this->belongsTo(CurrencyPlan::class, 'currency_plan');
    }
}
