<?php


namespace My\CustomDescription\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class CustomDescription extends AbstractDb

{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('allow_add_description', 'customer_email');
    }

}
