<?php

namespace My\CustomDescription\Ui\DataProvider\Customer;

use Magento\Framework\Data\Collection;
use Magento\Ui\DataProvider\AddFieldToCollectionInterface;

class AddCustomField implements AddFieldToCollectionInterface
{
    public function addField(Collection $collection, $field, $alias = null)
    {
        $collection->joinField('description', 'allow_add_description', 'description', 'customer_email=email', null, 'left');
    }
}

