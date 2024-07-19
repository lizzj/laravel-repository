<?php
namespace Morisawa\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 * @package Morisawa\Repository\Providers
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
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../resources/config/repository.php' => config_path('repository.php')
        ]);

        $this->mergeConfigFrom(__DIR__ . '/../../../resources/config/repository.php', 'repository');

        $this->loadTranslationsFrom(__DIR__ . '/../../../resources/lang', 'repository');
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands('Morisawa\Repository\Generators\Commands\RepositoryCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\TransformerCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\PresenterCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\EntityCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\ValidatorCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\ControllerCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\BindingsCommand');
        $this->commands('Morisawa\Repository\Generators\Commands\CriteriaCommand');
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
