<?php

namespace App\Providers;

use App\Bpmn\Manager;
use App\JDD\JDD;
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
        //
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
