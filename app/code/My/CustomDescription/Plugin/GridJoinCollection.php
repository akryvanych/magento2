<?php

namespace My\CustomDescription\Plugin;

use Magento\Framework\View\Element\UiComponent\DataProvider\CollectionFactory;

class GridJoinCollection
{

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
