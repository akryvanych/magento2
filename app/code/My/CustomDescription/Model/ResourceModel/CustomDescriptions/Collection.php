<?php
declare(strict_types=1);

namespace My\CustomDescription\Model\ResourceModel\CustomDescriptions;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use My\CustomDescription\Model\CustomDescription;
use My\CustomDescription\Model\ResourceModel\CustomDescription as CustomDescriptionResourceModel;

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
        $this->_init(CustomDescription::class, CustomDescriptionResourceModel::class);
    }
}
