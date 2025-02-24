<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyPlan extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function investments(){
        return $this->hasMany(CurrencyPlanInvestment::class , 'currency_plan');
    }
}
