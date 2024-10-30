<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPlatformEarning extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','plan_id','investment_return'];
}
