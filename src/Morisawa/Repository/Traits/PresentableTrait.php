<?php

namespace Morisawa\Repository\Traits;

use Illuminate\Support\Arr;
use Morisawa\Repository\Contracts\PresenterInterface;

/**
 * Class PresentableTrait
 *
 * @author Morisawa Kana
 */
trait PresentableTrait
{
    /**
     * @var PresenterInterface
     */
    protected $presenter = null;

    /**
     * @return $this
     */
    public function setPresenter(PresenterInterface $presenter)
    {
        $this->presenter = $presenter;

        return $this;
    }

    /**
     * @param  null  $default
     * @return mixed|null
     */
    public function present($key, $default = null)
    {
        if ($this->hasPresenter()) {
            $data = $this->presenter()['data'];

            return Arr::get($data, $key, $default);
        }

        return $default;
    }

    /**
     * @return bool
     */
    protected function hasPresenter()
    {
        return isset($this->presenter) && $this->presenter instanceof PresenterInterface;
    }

    /**
     * @return $this|mixed
     */
    public function presenter()
    {
        if ($this->hasPresenter()) {
            return $this->presenter->present($this);
        }

        return $this;
    }
}
