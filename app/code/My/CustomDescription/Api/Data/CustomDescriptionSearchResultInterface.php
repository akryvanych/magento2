<?php
declare(strict_types=1);

namespace My\CustomDescription\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CustomDescriptionSearchResultInterface extends SearchResultsInterface
{

    /**
     * @return CustomDescriptionInterface[]
     */
    public function getItems();

    /**
     * @param CustomDescriptionInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
