<?php

/*
 * @Author: もりさわかな
 * @LastEditTime: 2026-03-23 17:08:58
 */

namespace Morisawa\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @author Morisawa Kana
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../../resources/config/repository.php' => config_path('repository.php'),
        ]);
        $this->mergeConfigFrom(__DIR__.'/../../../resources/config/repository.php', 'repository');

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Morisawa\Repository\Generators\Commands\RepositoryCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\ControllerCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\CriteriaCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\RequestCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\ModelCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\JobCommand');
        $this->app->register('Morisawa\Repository\Providers\EventServiceProvider');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
