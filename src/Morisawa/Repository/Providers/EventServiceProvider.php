<?php
namespace Morisawa\Repository\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EventServiceProvider
 * @package Morisawa\Repository\Providers
 * @author Morisawa Kana
 */
class EventServiceProvider extends ServiceProvider
{

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'Morisawa\Repository\Events\RepositoryEntityCreated' => [
            'Morisawa\Repository\Listeners\CleanCacheRepository'
        ],
        'Morisawa\Repository\Events\RepositoryEntityUpdated' => [
            'Morisawa\Repository\Listeners\CleanCacheRepository'
        ],
        'Morisawa\Repository\Events\RepositoryEntityDeleted' => [
            'Morisawa\Repository\Listeners\CleanCacheRepository'
        ]
    ];

    /**
     * Register the application's event listeners.
     *
     * @return void
     */
    public function boot()
    {
        $events = app('events');

        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
