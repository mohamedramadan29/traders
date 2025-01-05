<?php

namespace App\Models\front;

use App\Models\admin\Userstoragedailyinvestment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageInvestment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function User(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function DailyInvestments(){
        return $this->hasMany(Userstoragedailyinvestment::class,'investment_id');
    }
}
