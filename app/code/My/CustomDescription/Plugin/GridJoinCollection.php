<?php

declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;

/**
 * Class GridJoinCollection
 * @package My\CustomDescription\Plugin
 *
 * Join custom row 'is_allowed_description' to customer table grid
 */
class GridJoinCollection
{
    /**
     * @param CollectionFactory $subject
     * @param $collection
     * @param $requestName
     * @return mixed
     */
    public function afterGetReport(
        CollectionFactory $subject,
        $collection,
        $requestName
    ) {
        if ($requestName == 'customer_listing_data_source') {
            $select = $collection->getSelect();
            $select->joinLeft(
                ["secondTable" => $collection->getTable("allow_add_description")],
                'email = customer_email',
                ['is_allowed_description']
            );
        }
        return $collection;
    }
}
