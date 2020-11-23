<?php

declare(strict_types=1);

namespace My\CustomDescription\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use My\CustomDescription\Api\Data\CustomDescriptionExtensionInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

class CustomDescription extends AbstractExtensibleModel implements CustomDescriptionInterface
{

    /** @var  array */
    public $extensionAttributes;

    /**
     * @inheritdoc
     */
    public function getDescriptionId()
    {
        return $this->getData(self::DESCRIPTION_ID);
    }

    /**
     * @inheritdoc
     */
    public function setDescriptionId(int $descriptionId): CustomDescriptionInterface
    {
        return $this->setData(self::DESCRIPTION_ID, $descriptionId);
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * @inheritdoc
     */
    public function setDescription(string $description): CustomDescriptionInterface
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerEmail()
    {
        return $this->getData(self::CUSTOMER_EMAIL);
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
        return $this->getData(self::IS_ALLOWED_DESCRIPTION);
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
        return $this->extensionAttributes;
    }

    /**
     * @inheritdoc
     */
    public function setExtensionAttributes(CustomDescriptionExtensionInterface $extensionAttributes)
    {
        $this->extensionAttributes = $extensionAttributes;
        return $this;
    }
}
