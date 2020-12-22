<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Plugin\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;

/**
 * Add Custom Description after get product
 */
class AfterGetCustomProductDescription
{
    /** @var AddCustomProductDescription */
    private $addCustomProductDescription;

    /**
     * Repository constructor.
     * @param AddCustomProductDescription $addCustomProductDescription
     */
    public function __construct(AddCustomProductDescription $addCustomProductDescription)
    {
        $this->addCustomProductDescription = $addCustomProductDescription;
    }

    /**
     * Add Custom Description after get product
     *
     * @param ProductRepositoryInterface $subject
     * @param ProductInterface           $product
     * @return ProductInterface
     * @SuppressWarnings("unused")
     */
    public function afterGet(
        ProductRepositoryInterface $subject,
        ProductInterface $product
    ): ProductInterface {
        $this->addCustomProductDescription->addCustomProductDescription($product);

        return $product;
    }
}
