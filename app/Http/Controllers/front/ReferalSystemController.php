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
        $oldsum = $user->ReferalWithdraws->sum('amount');

        return view('front.user.referral_system', compact('referrals','oldsum'));
    }
}
