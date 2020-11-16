<?php
namespace My\CustomDescription\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;
use My\CustomDescription\Api\Data\CustomDescriptionExtensionInterface;

class CustomDescription extends AbstractExtensibleModel implements CustomDescriptionInterface
{

    /** @var  array  */
    protected $extensionAttributes;

    /**
     * @inheritdoc
     */
    public function setDescriptionId($descriptionId)
    {
        return $this->setData(self::DESCRIPTION_ID, $descriptionId);
    }

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
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
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
    public function setCustomerEmail($customerEmail)
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
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
    public function setIsAllowedDescription($isAllowedDescription)
    {
        return $this->setData(self::IS_ALLOWED_DESCRIPTION, $isAllowedDescription);
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
    public function setExtensionAttributes(
        CustomDescriptionExtensionInterface $extensionAttributes
    ) {
        $this->extensionAttributes = $extensionAttributes;
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getExtensionAttributes()
    {
        return $this->extensionAttributes;
    }
}
