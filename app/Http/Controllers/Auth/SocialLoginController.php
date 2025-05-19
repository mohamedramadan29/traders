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
            ### how can get the referral code from the url when the user login from social login
            $referral_code = request()->get('referral_code');
            $referring_user = null;
            if ($referral_code) {
                $referring_user = User::where('referral_code', $referral_code)->first();
            }
            $new_user_referral_code = Str::random(10);
            $check_new_user_referral_code = User::where('referral_code', $new_user_referral_code)->count();
            if ($check_new_user_referral_code > 0) {
                $new_user_referral_code = $new_user_referral_code . '-' . $check_new_user_referral_code;
            }
            $user = User::create([
                'name' => $user_provider->name,
                'email' => $user_provider->email,
                'google_token' => $user_provider->token,
                'account_status' => 1,
                'password' => Hash::make(Str::random(8)),
                'referral_code' => $new_user_referral_code,
                'referred_by' => $referring_user ? $referring_user->id : null,
            ]);
            Auth::login($user);
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return $e;
        }
    }
}
