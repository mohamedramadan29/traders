<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function platform()
    {
        return $this->belongsTo(Platform::class,'platform_id');
    }
}