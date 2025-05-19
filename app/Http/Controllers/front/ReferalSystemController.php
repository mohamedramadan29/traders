<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferalSystemController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $referrals = $user->referrals;
        return view('front.user.referral_system', compact('referrals'));
    }
}
