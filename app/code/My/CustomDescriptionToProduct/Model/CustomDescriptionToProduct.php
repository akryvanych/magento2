<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use My\CustomDescriptionToProduct\Api\Data\CustomDescriptionToProductInterface;

/**
 * CustomDescriptionToProduct Model
 */
class CustomDescriptionToProduct extends AbstractExtensibleModel implements CustomDescriptionToProductInterface
{
    /**
     * @inheritdoc
     */
    public function getCommentId(): int
    {
        return (int) $this->getData(self::COMMENT_ID);
    }

    /**
     * @inheritdoc
     */
    public function setCommentId(int $commentId): CustomDescriptionToProduct
    {
        return $this->setData(self::COMMENT_ID, $commentId);
    }

    /**
     * @inheritdoc
     */
    public function getProductId(): int
    {
        return (int) $this->getData(self::PRODUCT_ID);
    }

    /**
     * @inheritdoc
     */
    public function setProductId(int $productId): CustomDescriptionToProductInterface
    {
        return $this->setData(self::PRODUCT_ID, $productId);
    }

    /**
     * @inheritdoc
     */
    public function getCustomCustomerDescriptionToProduct(): string
    {
        return (string) $this->getData(self::DESCRIPTION_TO_PRODUCT);
    }

    /**
     * @inheritdoc
     */
    public function setCustomCustomerDescriptionToProduct(
        string $customCustomerDescriptionToProduct
    ): CustomDescriptionToProductInterface {
        return $this->setData(self::DESCRIPTION_TO_PRODUCT, $customCustomerDescriptionToProduct);
    }

    /**
     * @inheritDoc
     */
    public function setCustomerEmail(string $customerEmail): CustomDescriptionToProductInterface
    {
        return $this->setData(self::CUSTOMER_EMAIL, $customerEmail);
    }

    /**
     * @inheritDoc
     */
    public function getCustomerEmail(): string
    {
        return (string) $this->getData(self::CUSTOMER_EMAIL);
    }

    /**
     * @inheritDoc
     */
    public function setIsApproved(bool $isApproved): CustomDescriptionToProductInterface
    {
        return $this->setData(self::IS_APPROVED, $isApproved);
    }

    /**
     * @inheritDoc
     */
    public function getIsApproved(): bool
    {
        return (bool) $this->getData(self::IS_APPROVED);
    }

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel\CustomDescriptionToProduct::class);
    }
}
