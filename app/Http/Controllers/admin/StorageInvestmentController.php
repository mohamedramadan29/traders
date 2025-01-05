<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\front\StorageInvestment;
use Illuminate\Http\Request;

class StorageInvestmentController extends Controller
{
    use Message_Trait;

    public function index(){
        $storages = StorageInvestment::all();
        return view('admin.Storage.index',compact('storages'));
    }
}
