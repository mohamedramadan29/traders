<?php

namespace App\Models\front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OksInvestment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
