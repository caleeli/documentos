<?php

namespace App\Providers;

use App\Bpmn\Manager;
use App\Derivacion;
use App\JDD\JDD;
use App\Observers\DerivacionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Derivacion::observe(DerivacionObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('JDD',
            function () {
            return new JDD;
        });
        $this->app->bind('workflow.engine',
            function () {
            return new Manager;
        });
    }
}
