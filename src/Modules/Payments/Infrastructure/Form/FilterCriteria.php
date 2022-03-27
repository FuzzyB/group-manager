<?php


namespace App\Modules\Payments\Infrastructure\Form;


class FilterCriteria
{
    /** @var string */
    private string $sortByColumn;
    /** @var string */
    private string $orderType;
    /** @var string */
    private string $filterByColumn;
    /** @var string|null */
    private string|null $filterText;
    /** @var string */
    private string $auDate;

    /**
     * @return string
     */
    public function getSortByColumn(): string
    {
        return $this->sortByColumn;
    }

    /**
     * @param string $sortByColumn
     * @return void
     */
    public function setSortByColumn(string $sortByColumn): void
    {
        $this->sortByColumn = $sortByColumn;
    }

    /**
     * @return string
     */
    public function getOrderType(): string
    {
        return $this->orderType;
    }

    /**
     * @param string $orderType
     * @return void
     */
    public function setOrderType(string $orderType): void
    {
        $this->orderType = $orderType;
    }

    /**
     * @return string
     */
    public function getFilterByColumn(): string
    {
        return $this->filterByColumn;
    }

    /**
     * @param $filterByColumn
     * @return void
     */
    public function setFilterByColumn($filterByColumn): void
    {
        $this->filterByColumn = $filterByColumn;
    }

    /**
     * @return string|null
     */
    public function getFilterText(): string|null
    {
        return $this->filterText;
    }

    /**
     * @param string|null $filterText
     * @return void
     */
    public function setFilterText(?string $filterText): void
    {
        $this->filterText = $filterText;
    }

    /**
     * @param string $auDate
     * @return void
     */
    public function setAuDate(string $auDate): void
    {
        $this->auDate = $auDate;
    }

    /**
     * @return string
     */
    public function getAuDate(): string
    {
        return $this->auDate;
    }

}
