<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Workspace;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('user-workspace',function (User $user ,Workspace $workspace){
            return $user->id==$workspace->user_id;
        });

        Gate::define('user-order',function (User $user ,Order $order){
            return $user->id==$order->user_id;
        });

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
    }
}
