<?php


namespace App\Form;


class FilterCryteria
{
    /** @var string */
    private $sortByColumn;
    /** @var string */
    private $orderType;
    /** @var string */
    private $filterByColumn;
    /** @var string */
    private $filterText;
    /** @var string */
    private $auDate;

    /**
     * @return array
     */
    public function getSortByColumn(): string
    {
        return $this->sortByColumn;
    }

    /**
     * @param array $sortByColumn
     */
    public function setSortByColumn(string $sortByColumn): void
    {
        $this->sortByColumn = $sortByColumn;
    }

    /**
     * @return array
     */
    public function getOrderType(): string
    {
        return $this->orderType;
    }

    /**
     * @param array $orderType
     */
    public function setOrderType(string $orderType): void
    {
        $this->orderType = $orderType;
    }

    /**
     * @return mixed
     */
    public function getFilterByColumn()
    {
        return $this->filterByColumn;
    }

    /**
     * @param mixed $filterByColumn
     */
    public function setFilterByColumn($filterByColumn): void
    {
        $this->filterByColumn = $filterByColumn;
    }

    /**
     * @return mixed
     */
    public function getFilterText()
    {
        return $this->filterText;
    }

    /**
     * @param mixed $filterText
     */
    public function setFilterText($filterText): void
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
