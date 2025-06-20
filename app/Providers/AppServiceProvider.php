<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(function (\SocialiteProviders\Manager\SocialiteWasCalled $event) {
            $event->extendSocialite('vkontakte', \SocialiteProviders\VKontakte\Provider::class);
        });

        Blade::directive('proficiencyBonus', function ($expression) {
            return "<?php
                \$level = $expression;
                echo '+' . (\$level >= 17 ? 6 : (\$level >= 13 ? 5 : (\$level >= 9 ? 4 : (\$level >= 5 ? 3 : 2)));
            ?>";
        });
    }

}
