<?php
namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 * @package Morisawa\Repository\Events
 * @author Morisawa Kana
 */
class RepositoryEntityDeleting extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleting";
}
