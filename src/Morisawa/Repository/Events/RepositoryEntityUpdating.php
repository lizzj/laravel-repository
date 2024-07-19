<?php
namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 * @package Morisawa\Repository\Events
 * @author Morisawa Kana
 */
class RepositoryEntityUpdating extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updating";
}
