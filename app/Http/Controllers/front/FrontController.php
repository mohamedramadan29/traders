<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\admin\Plan;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $plans = Plan::where('status',1)->get();
        return view('front.index',compact('plans'));
    }
}
