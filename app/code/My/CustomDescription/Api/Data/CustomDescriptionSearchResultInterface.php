<?php
declare(strict_types=1);

namespace My\CustomDescription\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Custom Description Search Result Interface
 * @api
 */
interface CustomDescriptionSearchResultInterface extends SearchResultsInterface
{

    /**
     * Get Custom Description items
     *
     * @return CustomDescriptionInterface[]
     */
    public function getItems();

    /**
     * Set custom description items
     *
     * @param CustomDescriptionInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
