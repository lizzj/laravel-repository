<?php

namespace Morisawa\Repository\Events;

use Illuminate\Database\Eloquent\Model;
use Morisawa\Repository\Contracts\RepositoryInterface;

/**
 * Class RepositoryEntityCreated
 *
 * @package Morisawa\Repository\Events
 * @author Morisawa Kana
 */
class RepositoryEntityCreating extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "creating";

    public function __construct(RepositoryInterface $repository, array $model)
    {
        parent::__construct($repository);
        $this->model = $model;
    }
}
