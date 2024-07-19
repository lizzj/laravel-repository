<?php
namespace Morisawa\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 * @package Morisawa\Repository\Events
 * @author Morisawa Kana
 */
class RepositoryEntityUpdated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updated";
}
