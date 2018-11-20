<?php

namespace aboalarm\BannerManagerSdk\Pagination;


/**
 * Class PaginationOptions
 * @package aboalarm\BannerManagerSdk\Pagination
 */
class PaginationOptions
{
    const DEFAULT_PAGE = 1;
    const DEFAULT_LIMIT = 10;

    /**
     * @var int
     */
    private $page;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var array|null
     */
    private $filter;

    /**
     * @var array|null
     */
    private $sort;

    public function __construct()
    {
        $this->page = static::DEFAULT_PAGE;
        $this->limit = static::DEFAULT_LIMIT;
        $this->filter = null;
        $this->sort = null;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @param int $page
     *
     * @return PaginationOptions
     */
    public function setPage(int $page): PaginationOptions
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     *
     * @return PaginationOptions
     */
    public function setLimit(int $limit): PaginationOptions
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param array|null $filter
     *
     * @return PaginationOptions
     */
    public function setFilter(array $filter): PaginationOptions
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * @param array|null $sort
     *
     * @return PaginationOptions
     */
    public function setSort(array $sort): PaginationOptions
    {
        $this->sort = $sort;

        return $this;
    }


}
