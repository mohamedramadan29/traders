<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TermsController extends Controller
{

    public function terms(){
        return view('front.terms');
    }
}
