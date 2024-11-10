<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\PublicSetting;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $public_setting = PublicSetting::first();
        $market_price = $public_setting['market_price'];
        $minimum_selling_price = $market_price * 1.01;
        return view('front.exchange.index',compact('market_price','minimum_selling_price'));
    }
}
