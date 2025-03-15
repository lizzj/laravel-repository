<?php

namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 *
 * @author Morisawa Kana
 */
class RepositoryEntityDeleting extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'deleting';
}
