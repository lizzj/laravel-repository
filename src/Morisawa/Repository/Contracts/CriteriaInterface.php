<?php

namespace Morisawa\Repository\Contracts;

/**
 * Interface CriteriaInterface
 *
 * @author Morisawa Kana
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
