<?php

namespace Aboalarm\BannerManagerSdk\Pagination;


use Aboalarm\BannerManagerSdk\Entity\Base;

class PaginatedCollection
{
    /**
     * @var Base[]|array
     */
    private $items;

    /**
     * @var int
     */
    private $total;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $totalPages;

    /**
     * @var array
     */
    private $pages;

    /**
     * PaginatedCollection constructor.
     *
     * @param array $items
     * @param int $count
     * @param int $total
     * @param int $currentPage
     * @param int $totPages
     * @param array $pages
     */
    public function __construct(
        array $items,
        int $count,
        int $total,
        int $currentPage,
        int $totPages,
        array $pages
    ) {
        $this->items = $items;
        $this->total = $total;
        $this->count = $count;
        $this->page = $currentPage;
        $this->totalPages = $totPages;
        $this->pages = $pages;
    }

    /**
     * @return Base[]|array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    /**
     * @return array
     */
    public function getPages(): array
    {
        return $this->pages;
    }
}
