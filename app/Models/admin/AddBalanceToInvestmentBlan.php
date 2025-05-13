<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddBalanceToInvestmentBlan extends Model
{
    use HasFactory;
    protected $fillable = [
        'plan_id',
        'amount',
        'type',
        'created_at',
        'updated_at',
    ];
}
