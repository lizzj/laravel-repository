<?php


namespace Morisawa\Fractal\Pagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class IlluminatePaginatorAdapter implements PaginatorInterface
{
    protected LengthAwarePaginator $paginator;

    /**
     * Create a new illuminate pagination adapter.
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage(): int
    {
        return $this->paginator->currentPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPage(): int
    {
        return $this->paginator->lastPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal(): int
    {
        return $this->paginator->total();
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): int
    {
        return $this->paginator->count();
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage(): int
    {
        return $this->paginator->perPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(int $page): string
    {
        return $this->paginator->url($page);
    }

    /**
     * Get the paginator instance.
     */
    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }
}
