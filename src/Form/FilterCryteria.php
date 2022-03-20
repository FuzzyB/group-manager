<?php


namespace App\Form;


class FilterCryteria
{
    private $sortByColumn;
    private $orderType;
    private $filterByColumn;
    private $filterText;

    public function __construct()
     {
//        $this->columnList = $columnList;
//        $this->orderTypeList = $orderTypeList;
//        $this->filterByColumns = $filterByColumns;
     }

    /**
     * @return array
     */
    public function getSortByColumn()
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


}
