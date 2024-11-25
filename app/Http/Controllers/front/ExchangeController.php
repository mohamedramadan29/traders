<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\admin\PublicSetting;
use App\Models\front\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExchangeController extends Controller
{
    use Message_Trait;
    public function index()
    {
        $public_setting = PublicSetting::first();
        $market_price = $public_setting['market_price'];
        $minimum_selling_price = $market_price * 1.01;
        $open_deals = SalesOrder::where('user_id',Auth::id())->where('status',0)->get();
        $closed_deals = SalesOrder::where('user_id',Auth::id())->where('status',1)->get();
        return view('front.exchange.index',compact('market_price','minimum_selling_price','open_deals'));
    }
}
