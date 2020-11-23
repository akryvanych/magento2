<?php

declare(strict_types=1);

namespace My\CustomDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface CustomDescriptionInterface extends ExtensibleDataInterface
{
    public const DESCRIPTION_ID = 'description_id';

    public const DESCRIPTION = 'description';

    public const CUSTOMER_EMAIL = 'customer_email';

    public const IS_ALLOWED_DESCRIPTION = 'is_allowed_description';


    /**
     *
     * @param int $descriptionId
     * @return self
     */
    public function setDescriptionId(int $descriptionId);

    /**
     * Get Description Id
     *
     * @return int
     */
    public function getDescriptionId();

    /**
     * Set Customer Email
     *
     * @param string $customerEmail
     * @return self
     */
    public function setCustomerEmail(string $customerEmail);

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
    public function setIsAllowedDescription(bool $isAllowedDescription);

    /**
     * Get Is Allowed
     *
     * @return bool
     */
    public function getIsAllowedDescription();

    /**
     * @return CustomDescriptionExtensionInterface|null
     */
    public function getExtensionAttributes();

    /**
     * @param CustomDescriptionExtensionInterface $extensionAttributes
     * @return self
     */
    public function setExtensionAttributes(CustomDescriptionExtensionInterface $extensionAttributes);
}
