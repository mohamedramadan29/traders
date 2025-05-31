<?php

namespace App\Models\front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferalWithdraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
