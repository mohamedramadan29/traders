<?php

namespace App\Models\front;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\admin\CurrencyPlanInvestment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
        'city',
        'status',
        'dollar_balance',
        'bin_balance',
        'image',
        'account_status',
        'referral_code',
        'referred_by',
    ];

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }
    public function Transactions()
    {
        return $this->hasMany(PaymentTransaction::class, 'user_id')->where('status', 'paid');
    }

    public function CurrencyInvestments(){
        return $this->hasMany(CurrencyPlanInvestment::class,'user_id')->where('currency_plan','!=',null)->get();
    }
    // public function CurrencyPlans(){
    //     return $this->hasMany(CurrencyPlanInvestment::class,'user_id')->where('currency_plan','!=',null);
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
