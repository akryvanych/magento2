<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Custom Description To Product Search Result Interface
 * @api
 */
interface CustomDescriptionToProductSearchResultInterface extends SearchResultsInterface
{
    /**
     * Get Custom Description items
     *
     * @return CustomDescriptionToProductInterface[]
     */
    public function getItems();

    /**
     * Set Custom Description items
     *
     * @param CustomDescriptionToProductInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
