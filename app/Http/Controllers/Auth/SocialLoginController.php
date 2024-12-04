<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\front\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function callback($provider)
    {
        try {
            $user_provider = Socialite::driver($provider)->user();
            $user_from_db = User::where('email', $user_provider->getEmail())->first();
            //dd($user);
            if ($user_from_db) {
                Auth::login($user_from_db);
                return redirect()->route('dashboard');
            }
            $user = User::create([
                'name' => $user_provider->name,
                'email' => $user_provider->email,
                'google_token' => $user_provider->token,
                'password' => Hash::make(Str::random(8)),
            ]);
            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
