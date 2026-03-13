<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $provider)
    {
        if ($provider === 'spotify') {
            return Socialite::driver($provider)
                ->scopes(['user-read-email', 'user-read-private'])
                ->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        $user = User::updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ],
            [
                'name' => $socialUser->getName() ?? $socialUser->getNickname(),
                'email' => $socialUser->getEmail(),
                'provider_token' => $socialUser->token,
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }
}
