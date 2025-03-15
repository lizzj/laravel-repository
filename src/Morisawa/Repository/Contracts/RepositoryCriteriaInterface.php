<?php

namespace Morisawa\Repository\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface RepositoryCriteriaInterface
 *
 * @author Morisawa Kana
 */
interface RepositoryCriteriaInterface
{
    /**
     * Push Criteria for filter the query
     *
     *
     * @return $this
     */
    public function pushCriteria($criteria);

    /**
     * Pop Criteria
     *
     *
     * @return $this
     */
    public function popCriteria($criteria);

    /**
     * Get Collection of Criteria
     *
     * @return Collection
     */
    public function getCriteria();

    /**
     * Find data by Criteria
     *
     *
     * @return mixed
     */
    public function getByCriteria(CriteriaInterface $criteria);

    /**
     * Skip Criteria
     *
     * @param  bool  $status
     * @return $this
     */
    public function skipCriteria($status = true);

    /**
     * Reset all Criterias
     *
     * @return $this
     */
    public function resetCriteria();
}
