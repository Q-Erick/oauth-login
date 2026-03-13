<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Spotify\SpotifyExtendSocialite;
use SocialiteProviders\Discord\DiscordExtendSocialite;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->app['events']->listen(
            SocialiteWasCalled::class,
            SpotifyExtendSocialite::class . '@handle'
        );

        $this->app['events']->listen(
            SocialiteWasCalled::class,
            DiscordExtendSocialite::class . '@handle'
        );
    }
}