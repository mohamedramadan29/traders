<?php

namespace App\Models\front;

use App\Models\admin\Plan;
use App\Models\admin\UserPlatformEarning;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','plan_id','total_investment','status'];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function plan(){
        return $this->belongsTo(Plan::class,'plan_id');
    }
    public function planinvestment(){
        return $this->belongsTo(UserPlatformEarning::class,'plan_id');
    }
}
