<?php

namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 *
 * @author Morisawa Kana
 */
class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'updated';
}
