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
        if (config('app.env') === 'production' || request()->header('x-forwarded-proto') == 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $settings = \App\Models\Setting::allAsArray();
                $view->with('site_settings', $settings);
                $view->with('site_name', $settings['site_name'] ?? 'Konfigin IT Solutions');
                $view->with('site_logo', $settings['site_logo'] ?? null);

                $global_menus = \App\Models\Menu::active()->ordered()->get();
                $view->with('global_menus', $global_menus);
                
                $global_kontak = \App\Models\Kontak::first();
                $view->with('global_kontak', $global_kontak);
            } catch (\Exception $e) {
                // Ignore if table doesn't exist yet
            }
        });
    }
}
