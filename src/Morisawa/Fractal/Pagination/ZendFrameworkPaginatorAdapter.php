<?php



namespace Morisawa\Fractal\Pagination;

use Zend\Paginator\Paginator;


class ZendFrameworkPaginatorAdapter implements PaginatorInterface
{
    protected Paginator $paginator;

    /**
     * The route generator.
     *
     * @var callable
     */
    protected $routeGenerator;

    public function __construct(Paginator $paginator, callable $routeGenerator)
    {
        $this->paginator = $paginator;
        $this->routeGenerator = $routeGenerator;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrentPage(): int
    {
        return $this->paginator->getCurrentPageNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function getLastPage(): int
    {
        return $this->paginator->count();
    }

    /**
     * {@inheritDoc}
     */
    public function getTotal(): int
    {
        return $this->paginator->getTotalItemCount();
    }

    /**
     * {@inheritDoc}
     */
    public function getCount(): int
    {
        return $this->paginator->getCurrentItemCount();
    }

    /**
     * {@inheritDoc}
     */
    public function getPerPage(): int
    {
        return $this->paginator->getItemCountPerPage();
    }

    /**
     * {@inheritDoc}
     */
    public function getUrl(int $page): string
    {
        return call_user_func($this->routeGenerator, $page);
    }

    public function getPaginator(): Paginator
    {
        return $this->paginator;
    }

    public function getRouteGenerator(): callable
    {
        return $this->routeGenerator;
    }
}
