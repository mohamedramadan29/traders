<?php

namespace App\Models\front;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\Userstoragedailyinvestment;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StorageInvestment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function DailyInvestments()
    {
        return $this->hasMany(Userstoragedailyinvestment::class, 'investment_id')->orderBy('created_at', 'desc');
    }

    // حساب العوائد الكلية لهذا التخزين
    public function getTotalReturnsAttribute()
    {
        return $this->DailyInvestments->sum('amount_return')->where('user_id', Auth::user()->id);
    }
}
