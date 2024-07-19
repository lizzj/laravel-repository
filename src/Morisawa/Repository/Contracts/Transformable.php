<?php
namespace Morisawa\Repository\Contracts;

/**
 * Interface Transformable
 * @package Morisawa\Repository\Contracts
 * @author Morisawa Kana
 */
interface Transformable
{
    /**
     * @return array
     */
    public function transform();
}
