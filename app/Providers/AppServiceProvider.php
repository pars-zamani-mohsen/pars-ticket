<?php

namespace App\Providers;

use App\Contracts\EmailServiceInterface;
use App\Contracts\SMSServiceInterface;
use App\Services\Notifications\KavenegarSMSService;
use App\Services\Notifications\LaravelEmailService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);

        $this->app->bind(SMSServiceInterface::class, KavenegarSMSService::class);
        $this->app->bind(EmailServiceInterface::class, LaravelEmailService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('styleOnce', function ($expression) {
            return true;
        });
    }
}
