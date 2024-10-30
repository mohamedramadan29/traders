<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\Message_Trait;
use App\Models\front\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Message_Trait;

    public function index()
    {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }
}
