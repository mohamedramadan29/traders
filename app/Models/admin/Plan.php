<?php

namespace App\Models\admin;

use App\Models\front\Invoice;
use App\Models\front\UserPlan;
use App\Models\front\UserStatment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function platform()
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function total_plans()
    {
        return $this->hasMany(UserPlan::class, 'plan_id');
    }

    public function investmentReturns()
    {
        return $this->hasMany(PlatformInvestmentReturn::class, 'plan_id');
    }

    public function PlanDailyInvestMentReturn()
    {
        return $this->hasMany(UserDailyInvestmentReturn::class, 'plan_id')
            ->where('user_id', Auth::id());
    }

    public function PlanStaments()
    {
        return $this->hasMany(UserStatment::class, 'plan_id')
            ->where('user_id', Auth::id());
    }

    public function UserPlans(){
        return $this->hasMany(UserPlan::class,'plan_id');
    }

}
