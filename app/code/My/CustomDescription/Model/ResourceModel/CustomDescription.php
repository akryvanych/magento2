<?php
declare(strict_types = 1);

namespace My\CustomDescription\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * CustomDescription Resource Model
 */
class CustomDescription extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected $_isPkAutoIncrement = false;

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('allow_add_description', 'customer_email');
    }
}
