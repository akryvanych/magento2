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
    public const COMMENT_ID = 'comment_id';

    public const PRODUCT_ID = 'product_id';

    public const DESCRIPTION_TO_PRODUCT = 'custom_customer_description_to_product';

    public const CUSTOMER_EMAIL = 'customer_email';

    public const IS_APPROVED = 'is_approved';

    /**
     * Get Comment Id
     *
     * @return int
     */
    public function getCommentId(): int;

    /**
     * Set Comment Id
     *
     * @param int $commentId
     * @return
     */
    public function setCommentId(int $commentId);

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
     * @SuppressWarnings(PHPMD)
     */
    public function getIsApproved(): bool;

    /**
     * Set Is Approved
     *
     * @param bool $isApproved
     * @return CustomDescriptionToProductInterface
     */
    public function setIsApproved(bool $isApproved): CustomDescriptionToProductInterface;
}
