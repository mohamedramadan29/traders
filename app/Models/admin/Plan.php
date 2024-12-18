<?php

namespace App\Models\admin;

use App\Models\front\Invoice;
use App\Models\front\UserPlan;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function platform()
    {
        return $this->belongsTo(Platform::class,'platform_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function total_plans(){
        return $this->hasMany(UserPlan::class, 'plan_id');
    }

    public function investmentReturns(){
        return $this->hasMany(PlatformInvestmentReturn::class,'plan_id');
    }

}
