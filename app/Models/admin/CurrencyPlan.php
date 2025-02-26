<?php

namespace App\Models\admin;

use App\Models\front\WithDrawCurrencyPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
