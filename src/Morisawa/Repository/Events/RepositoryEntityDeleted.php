<?php

namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 *
 * @author Morisawa Kana
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'deleted';
}
