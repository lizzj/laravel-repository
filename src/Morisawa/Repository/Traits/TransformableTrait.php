<?php

namespace Morisawa\Repository\Traits;

/**
 * Class TransformableTrait
 * @package Morisawa\Repository\Traits
 * @author Morisawa Kana
 */
trait TransformableTrait
{
    /**
     * @return array
     */
    public function transform()
    {
        return $this->toArray();
    }
}
