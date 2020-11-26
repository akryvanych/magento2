<?php

declare(strict_types=1);

namespace My\CustomDescription\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

class CustomDescription extends AbstractExtensibleModel implements CustomDescriptionInterface
{
    /**
     * @var  array
     */
    public $extensionAttributes;

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\CustomDescription::class);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerEmail()
    {
        return (string)$this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * @inheritdoc
     */
    public function setCustomerEmail(string $customerEmail): CustomDescriptionInterface
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * @inheritdoc
     */
    public function getIsAllowedDescription()
    {
        return (bool)$this->getData(self::IS_ALLOWED_DESCRIPTION);
    }

    /**
     * @inheritdoc
     */
    public function setIsAllowedDescription(bool $isAllowedDescription): CustomDescriptionInterface
    {
        return $this->setData(self::IS_ALLOWED_DESCRIPTION, $isAllowedDescription);
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(\My\CustomDescription\Api\Data\CustomDescriptionExtensionInterface $extensionAttributes)
    {
        $this->_setExtensionAttributes($extensionAttributes);
    }
}
