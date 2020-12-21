<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionsToProduct\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Search\Adapter\Mysql\Aggregation;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionsToProduct\Collection;
use My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionToProduct;

/**
 * Extra comments grid collection.
 */
class GridCollection extends Collection implements SearchResultInterface
{
    /** @var Aggregation\ */
    protected $aggregations;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Document::class, CustomDescriptionToProduct::class);
    }

    /**
     * @inheritdoc
     */
    public function getAggregations()
    {
        return $this->aggregations;
    }

    /**
     * @inheritdoc
     */
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    /**
     * @inheritdoc
     */
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }

    /**
     * @inheritdoc
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTotalCount()
    {
        return $this->getSize();
    }

    /**
     * @inheritdoc
     */
    public function setTotalCount($totalCount)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setItems(array $items = null)
    {
        return $this;
    }
}
