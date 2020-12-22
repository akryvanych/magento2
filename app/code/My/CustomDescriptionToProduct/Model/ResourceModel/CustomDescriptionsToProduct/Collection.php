<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionsToProduct;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use My\CustomDescriptionToProduct\Model\CustomDescriptionToProduct;
use My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionToProduct as
    CustomDescriptionToProductResourceModel;

/**
 * Custom description collection.
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(CustomDescriptionToProduct::class, CustomDescriptionToProductResourceModel::class);
    }
}
