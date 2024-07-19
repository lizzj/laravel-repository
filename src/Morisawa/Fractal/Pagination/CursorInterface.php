<?php

namespace Morisawa\Fractal\Pagination;

interface CursorInterface
{
    /**
     * Get the current cursor value.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function getCurrent();

    /**
     * Get the prev cursor value.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function getPrev();

    /**
     * Get the next cursor value.
     *
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function getNext();

    /**
     * Returns the total items in the current cursor.
     */
    public function getCount(): ?int;
}
