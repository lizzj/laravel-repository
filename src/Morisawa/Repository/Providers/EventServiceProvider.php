<?php

namespace Morisawa\Repository\Providers;

use Illuminate\Support\ServiceProvider;
use Morisawa\Repository\Listeners\CleanCacheRepository;

/**
 * Class EventServiceProvider
 *
 * @author Morisawa Kana
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    // 定义常量
    private const CLEAN_CACHE = CleanCacheRepository::class;

    protected $listen = [
        'Morisawa\Repository\Events\RepositoryEntityCreated' => [self::CLEAN_CACHE],
        'Morisawa\Repository\Events\RepositoryEntityUpdated' => [self::CLEAN_CACHE],
        'Morisawa\Repository\Events\RepositoryEntityDeleted' => [self::CLEAN_CACHE],
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
