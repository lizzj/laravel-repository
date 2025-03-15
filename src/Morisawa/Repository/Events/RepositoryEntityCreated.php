<?php

namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityCreated
 *
 * @author Morisawa Kana
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = 'created';
}
