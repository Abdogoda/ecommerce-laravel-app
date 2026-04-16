<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
        Paginator::useTailwind();

        View::composer('*', function ($view) {
            $view->with('generalSettings', app(\App\Settings\GeneralSettings::class));
            $view->with('socialSettings', app(\App\Settings\SocialSettings::class));
        });

        // Register a blade directive for currency formatting
        \Illuminate\Support\Facades\Blade::directive('currency', function ($expression) {
            return "<?php echo \App\Helpers\CurrencyHelper::formatPrice({$expression}); ?>";
        });
    }
}