<?php
namespace Morisawa\Repository\Contracts;

/**
 * Interface CriteriaInterface
 * @package Morisawa\Repository\Contracts
 * @author Morisawa Kana
 */
interface CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository);
}
