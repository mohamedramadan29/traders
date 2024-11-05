<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use Illuminate\Http\Request;

class ExchangeController extends Controller
{
    use Message_Trait;
    public function index()
    {
        return view('front.exchange.index');
    }
}
