<?php

namespace Alimi7372\BPMS;

use Illuminate\Support\ServiceProvider;

class BPMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'BPMS:langs');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'BPMS:views');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/bpms'),
            __DIR__ . '/../config/bpms.php' => config_path('bpms.php'),
            __DIR__ . '/../public' => public_path('vendor/bpms'),
            __DIR__ . '/../lang' => $this->app->langPath('vendor/bpms2'),
        ],'BPMS');
    }
}
