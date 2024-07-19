<?php
namespace Morisawa\Repository\Contracts;

/**
 * Interface Presentable
 * @package Morisawa\Repository\Contracts
 * @author Morisawa Kana
 */
interface Presentable
{
    /**
     * @param PresenterInterface $presenter
     *
     * @return mixed
     */
    public function setPresenter(PresenterInterface $presenter);

    /**
     * @return mixed
     */
    public function presenter();
}
