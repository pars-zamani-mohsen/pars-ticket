<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Ticket;
use App\Policies\TicketPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Ticket::class => TicketPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::provider('custom', function ($app, array $config) {
            return new class($app['hash'], $config['model']) extends \Illuminate\Auth\EloquentUserProvider
            {
                public function retrieveByCredentials(array $credentials)
                {
                    if (empty($credentials)) {
                        return;
                    }

                    $query = $this->createModel()->newQuery();

                    if (isset($credentials['email'])) {
                        $query->where('email', $credentials['email']);
                    } elseif (isset($credentials['mobile'])) {
                        $query->where('mobile', $credentials['mobile']);
                    }

                    return $query->first();
                }
            };
        });
    }
}
