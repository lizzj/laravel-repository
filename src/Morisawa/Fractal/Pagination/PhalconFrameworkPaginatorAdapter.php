<?php

namespace Morisawa\Fractal\Pagination;

class PhalconFrameworkPaginatorAdapter implements PaginatorInterface
{
    /**
     * A slice of the result set to show in the pagination
     */
    private \stdClass $paginator;

    public function __construct(\stdClass $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage(): int
    {
        return $this->paginator->current;
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPage(): int
    {
        return $this->paginator->last;
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal(): int
    {
        return $this->paginator->total_items;
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): int
    {
        return $this->paginator->total_pages;
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage(): int
    {
        // $this->paginator->items->count()
        // Because when we use raw sql have not this method
        return count($this->paginator->items);
    }

    /**
     * {@inheritDoc}
     */
    public function getNext(): int
    {
        return $this->paginator->next;
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(int $page): string
    {
        return (string) $page;
    }
}
