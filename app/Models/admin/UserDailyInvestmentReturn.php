<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyInvestmentReturn extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plan()
    {
        return $this->belongsTo(Plan::class,'plan_id');
    }
}
