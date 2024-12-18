<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlatformEarning extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','plan_id','investment_return','profit_percentage','daily_earning'];

    public function plan_invest()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }


}
