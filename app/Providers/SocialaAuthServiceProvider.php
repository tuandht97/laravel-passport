<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Bridge\UserRepository;
use Laravel\Passport\Passport;
use App\Http\Grant\SocialGrant;
use League\OAuth2\Server\AuthorizationServer;

class SocialaAuthServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->afterResolving(AuthorizationServer::class, function (AuthorizationServer $server) {
            $grant = $this->makeGrant();
            $server->enableGrantType($grant, Passport::tokensExpireIn());
        });
    }

    private function makeGrant()
    {
        $grant = new SocialGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}
