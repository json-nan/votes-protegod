<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class TwitchAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('twitch')->redirect();
    }

    public function callback()
    {
        $twitchUser = Socialite::driver('twitch')->user();

        $user = User::updateOrCreate([
            'email' => $twitchUser->email,
        ], [
            'name' => $twitchUser->name,
            'avatar' => $twitchUser->avatar,
            'type' => UserType::USER,
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
