<?php

namespace KoursesPhp;

class PaginatedCollection extends Collection
{
    /**
     * @var \KoursesPhp\PaginationMetadata
     */
    protected $paginationMetadata;

    /**
     * Set paginated metadata object.
     *
     * @param   PaginationMetadata  $metadata
     *
     * @return  void
     */
    public function setPaginationMetadata(PaginationMetadata $metadata)
    {
        $this->paginationMetadata = $metadata;
    }

    /**
     * Return current page number.
     *
     * @return  int
     */
    public function getCurrentPage()
    {
        return $this->paginationMetadata !== null ? $this->paginationMetadata->current_page : 0;
    }

    /**
     * Return last page number.
     *
     * @return  int
     */
    public function getLastPage()
    {
        return $this->paginationMetadata !== null ? $this->paginationMetadata->last_page : 0;
    }

    /**
     * Return total items number.
     *
     * @return  int
     */
    public function getTotal()
    {
        return $this->paginationMetadata !== null ? $this->paginationMetadata->total : 0;
    }

    /**
     * Return number of items per page.
     *
     * @return  int
     */
    public function getPerPage()
    {
        return $this->paginationMetadata !== null ? $this->paginationMetadata->per_page : 0;
    }

    /**
     * Return current page items range end.
     *
     * @return  int
     */
    public function getTo()
    {
        return $this->paginationMetadata !== null ? $this->paginationMetadata->to : 0;
    }

    /**
     * Return current page items range start.
     *
     * @return  int
     */
    public function getFrom()
    {
        return $this->paginationMetadata !== null ? $this->paginationMetadata->from : 0;
    }
}
