<?php
namespace Morisawa\Repository\Contracts;

/**
 * Interface PresenterInterface
 * @package Morisawa\Repository\Contracts
 * @author Morisawa Kana
 */
interface PresenterInterface
{
    /**
     * Prepare data to present
     *
     * @param $data
     *
     * @return mixed
     */
    public function present($data);
}
