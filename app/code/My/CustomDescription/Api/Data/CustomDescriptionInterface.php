<?php

namespace My\CustomDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface CustomDescriptionInterface extends ExtensibleDataInterface
{
    const DESCRIPTION_ID = 'description_id';

    const DESCRIPTION = 'description';

    const CUSTOMER_EMAIL = 'customer_email';

    const IS_ALLOWED_DESCRIPTION = 'is_allowed_description';


    /**
     *
     * @param int $descriptionId
     * @return self
     */
    public function setDescriptionId($descriptionId);

    /**
     * Get Description Id
     *
     * @return int
     */
    public function getDescriptionId();

    /**
     * Set Description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description);

    /**
     * Get Description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Set Customer Email
     *
     * @param string $customerEmail
     * @return self
     */
    public function setCustomerEmail($customerEmail);

    /**
     * Get Customer Email
     *
     * @return string
     */
    public function getCustomerEmail();

    /**
     * Set Is Allowed
     *
     * @param bool $isAllowedDescription
     * @return self
     */
    public function setIsAllowedDescription($isAllowedDescription);

    /**
     * Get Is Allowed
     *
     * @return bool
     */
    public function getIsAllowedDescription();

    /**
     * @return \My\CustomDescription\Api\Data\CustomDescriptionExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param \My\CustomDescription\Api\Data\CustomDescriptionExtensionInterface $extensionAttributes
     * @return self
     */
    public function setExtensionAttributes(
        \My\CustomDescription\Api\Data\CustomDescriptionExtensionInterface $extensionAttributes
    );
}
