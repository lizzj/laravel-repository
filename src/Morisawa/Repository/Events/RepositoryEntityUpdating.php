<?php

namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 *
 * @author Morisawa Kana
 */
class RepositoryEntityUpdating extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'updating';
}
