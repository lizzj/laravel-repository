<?php
namespace Morisawa\Fractal\Pagination;


interface PaginatorInterface
{
    /**
     * Get the current page.
     */
    public function getCurrentPage(): int;

    /**
     * Get the last page.
     */
    public function getLastPage(): int;

    /**
     * Get the total.
     */
    public function getTotal(): int;

    /**
     * Get the count.
     */
    public function getCount(): int;

    /**
     * Get the number per page.
     */
    public function getPerPage(): int;

    /**
     * Get the url for the given page.
     */
    public function getUrl(int $page): string;
}
