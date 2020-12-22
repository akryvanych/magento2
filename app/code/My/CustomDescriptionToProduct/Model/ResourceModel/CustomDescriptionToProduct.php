<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Custom Description Resource Model
 */
class CustomDescriptionToProduct extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('custom_product_description', 'comment_id');
    }
}
