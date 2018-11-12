<?php

namespace aboalarm\BannerManagerSdk\Pagination;


use aboalarm\BannerManagerSdk\Entity\Base;

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
    private $currentPage;

    /**
     * @var int
     */
    private $totPages;

    /**
     * PaginatedCollection constructor.
     *
     * @param array $items
     * @param int   $total
     * @param int   $currentPage
     * @param int   $totPages
     */
    public function __construct(array $items, int $total, int $currentPage, int $totPages)
    {
        $this->items = $items;
        $this->total = $total;
        $this->count = count($items);
        $this->currentPage = $currentPage;
        $this->totPages = $totPages;
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
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @return int
     */
    public function getTotPages(): int
    {
        return $this->totPages;
    }
}
