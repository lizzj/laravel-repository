<?php
namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityCreated
 * @package Morisawa\Repository\Events
 * @author Morisawa Kana
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "created";
}
