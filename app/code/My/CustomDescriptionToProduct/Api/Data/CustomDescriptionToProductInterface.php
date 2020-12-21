<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

/**
 * Custom description to product interface for product.
 * @api
 */
interface CustomDescriptionToProductInterface extends ExtensibleDataInterface
{
    public const ENTITY_ID = 'entity_id';

    public const PRODUCT_ID = 'product_id';

    public const DESCRIPTION_TO_PRODUCT = 'custom_customer_description_to_product';

    public const CUSTOMER_EMAIL = 'customer_email';

    public const IS_APPROVED = 'is_approved';

    /**
     * Get Entity Id
     *
     * @return int
     */
    public function getEntityId(): int;

    /**
     * Set Entity Id
     *
     * @param $entityId
     * @return
     */
    public function setEntityId($entityId);

    /**
     * Set Product Id
     *
     * @param int $productId
     * @return self
     */
    public function setProductId(int $productId): CustomDescriptionToProductInterface;

    /**
     * Get Product Id
     *
     * @return int
     */
    public function getProductId(): int;

    /**
     * Set Custom Customer Description To Product
     *
     * @param string $customCustomerDescriptionToProduct
     * @return self
     */
    public function setCustomCustomerDescriptionToProduct(
        string $customCustomerDescriptionToProduct
    ): CustomDescriptionToProductInterface;

    /**
     * Get Custom Customer Description To Product
     *
     * @return string
     */
    public function getCustomCustomerDescriptionToProduct(): string;

    /**
     * Set Customer Email
     *
     * @param string $customerEmail
     * @return self
     */
    public function setCustomerEmail(string $customerEmail): CustomDescriptionToProductInterface;

    /**
     * Get Customer Email
     *
     * @return string
     */
    public function getCustomerEmail(): string;

    /**
     * Get Is Approved
     *
     * @return bool
     */
    public function getIsApproved(): bool;

    /**
     * Set Is Approved
     *
     * @param $isApproved
     * @return CustomDescriptionToProductInterface
     */
    public function setIsApproved($isApproved): CustomDescriptionToProductInterface;
}
