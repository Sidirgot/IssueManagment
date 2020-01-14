<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Project' => 'App\Policies\ProjectPolicy',
        'App\Issue' => 'App\Policies\IssuePolicy',
        'App\Followup' => 'App\Policies\FollowupPolicy',
        'App\User' => 'App\Policies\UserProfilePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Passport::routes(function ($router) {
        //     $router->forAccessTokens();
        //     $router->forPersonalAccessTokens();
        //     $router->forTransientTokens();
        // });

        // Passport::tokensExpireIn(Carbon::now()->addMinutes(10));

        // Passport::refreshTokensExpireIn(Carbon::now()->addDays(10));
    }
}
