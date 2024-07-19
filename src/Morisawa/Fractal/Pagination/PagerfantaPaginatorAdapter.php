<?php


namespace Morisawa\Fractal\Pagination;

use Pagerfanta\Pagerfanta;

class PagerfantaPaginatorAdapter implements PaginatorInterface
{
    protected Pagerfanta $paginator;

    /**
     * The route generator.
     *
     * @var callable
     */
    protected $routeGenerator;

    public function __construct(Pagerfanta $paginator, callable $routeGenerator)
    {
        $this->paginator = $paginator;
        $this->routeGenerator = $routeGenerator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage(): int
    {
        return $this->paginator->getCurrentPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPage(): int
    {
        return $this->paginator->getNbPages();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal(): int
    {
        return count($this->paginator);
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): int
    {
        return count($this->paginator->getCurrentPageResults());
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage(): int
    {
        return $this->paginator->getMaxPerPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(int $page): string
    {
        return call_user_func($this->routeGenerator, $page);
    }

    public function getPaginator(): Pagerfanta
    {
        return $this->paginator;
    }

    public function getRouteGenerator(): callable
    {
        return $this->routeGenerator;
    }
}
