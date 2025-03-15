<?php

namespace Morisawa\Repository\Contracts;

use Illuminate\Contracts\Cache\Repository as CacheRepository;

/**
 * Interface CacheableInterface
 *
 * @author Morisawa Kana
 */
interface CacheableInterface
{
    /**
     * Set Cache Repository
     *
     *
     * @return $this
     */
    public function setCacheRepository(CacheRepository $repository);

    /**
     * Return instance of Cache Repository
     *
     * @return CacheRepository
     */
    public function getCacheRepository();

    /**
     * Get Cache key for the method
     *
     *
     * @return string
     */
    public function getCacheKey($method, $args = null);

    /**
     * Get cache time
     *
     * @return int
     */
    public function getCacheTime();

    /**
     * Skip Cache
     *
     * @param  bool  $status
     * @return $this
     */
    public function skipCache($status = true);
}
