<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $settings = \App\Models\Setting::allAsArray();
                $view->with('site_settings', $settings);
                $view->with('site_name', $settings['site_name'] ?? 'Konfigin IT Solutions');
                $view->with('site_logo', $settings['site_logo'] ?? null);
            } catch (\Exception $e) {
                // Ignore if table doesn't exist yet
            }
        });
    }
}
