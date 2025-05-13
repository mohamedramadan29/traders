<?php

namespace App\Models\admin;

use App\Models\front\CurrencyPlanStep;
use Illuminate\Database\Eloquent\Model;
use App\Models\front\WithDrawCurrencyPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrencyPlan extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function investments(){
        return $this->hasMany(CurrencyPlanInvestment::class , 'currency_plan');
    }

    public function withdrawStatments(){
        return $this->hasMany(WithDrawCurrencyPlan::class,'currency_plan');
    }

    public function CurrencyPlanSteps(){
        return $this->hasMany(CurrencyPlanStep::class , 'currency_plan_id');
    }
    public function AddBalanceToInvestmentBlans(){
        return $this->hasMany(AddBalanceToInvestmentBlan::class , 'plan_id')->where('type' , 'add');
    }
    public function RemoveBalanceToInvestmentBlans(){
        return $this->hasMany(AddBalanceToInvestmentBlan::class , 'plan_id')->where('type' , 'remove');
    }
}
