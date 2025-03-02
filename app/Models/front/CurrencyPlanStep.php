<?php

namespace App\Models\front;

use App\Models\admin\CurrencyPlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrencyPlanStep extends Model
{
    use HasFactory;
    protected $table = 'currency_plan_steps';
    protected $fillable = ['currency_plan_id', 'currency_price','user_id'];
    public function currencyPlan()
    {
        return $this->belongsTo(CurrencyPlan::class, 'currency_plan_id');
    }
}
