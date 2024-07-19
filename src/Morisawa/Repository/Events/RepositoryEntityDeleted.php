<?php
namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 * @package Morisawa\Repository\Events
 * @author Morisawa Kana
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
