<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $webSettings = \Illuminate\Support\Facades\Cache::remember('web_settings_all', 300, function () {
                try {
                    return \App\Models\WebSetting::pluck('value', 'key')->toArray();
                } catch (\Exception $e) {
                    return [];
                }
            });
            $view->with('webSettings', $webSettings);
        });
    }
}
