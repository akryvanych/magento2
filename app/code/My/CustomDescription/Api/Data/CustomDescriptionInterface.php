<?php
declare(strict_types=1);

namespace My\CustomDescription\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Custom description interface for customer.
 * @api
 */
interface CustomDescriptionInterface extends ExtensibleDataInterface
{
    public const CUSTOMER_EMAIL = 'customer_email';

    public const IS_ALLOWED_DESCRIPTION = 'is_allowed_description';

    /**
     * Set Customer Email
     *
     * @param string $customerEmail
     * @return self
     */
    public function setCustomerEmail(string $customerEmail): CustomDescriptionInterface;

    /**
     * Get Customer Email
     *
     * @return string
     */
    public function getCustomerEmail() : string;

    /**
     * Set Is Allowed
     *
     * @param bool $isAllowedDescription
     * @return self
     */
    public function setIsAllowedDescription(bool $isAllowedDescription): CustomDescriptionInterface;

    /**
     * Get Is Allowed
     *
     * @SuppressWarnings("unchecked")
     * @return bool
     */
    public function getIsAllowedDescription() : bool;
}
