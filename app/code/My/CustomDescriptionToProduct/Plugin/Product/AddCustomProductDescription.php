<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Plugin\Product;

use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\Catalog\Api\Data\ProductInterface;
use My\CustomDescriptionToProduct\Api\CustomDescriptionToProductRepositoryInterface as DescriptionRepository;

/**
 * Add Custom Product Description
 */
class AddCustomProductDescription
{
    /** @var ProductExtensionFactory */
    private $productExtensionFactory;

    /** @var DescriptionRepository */
    private $descriptionRepository;

    /**
     * Repository constructor.
     *
     * @param ProductExtensionFactory $productExtensionFactory
     * @param DescriptionRepository   $descriptionRepository
     *
     */
    public function __construct(
        ProductExtensionFactory $productExtensionFactory,
        DescriptionRepository $descriptionRepository
    ) {
        $this->productExtensionFactory = $productExtensionFactory;
        $this->descriptionRepository   = $descriptionRepository;
    }

    /**
     * Add Custom Product Description
     *
     * @param ProductInterface $product
     * @return self
     */
    public function addCustomProductDescription(ProductInterface $product): AddCustomProductDescription
    {
        $extensionAttributes = $product->getExtensionAttributes();
        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->productExtensionFactory->create();
        }
        if ($product->getId() != null) {
            $customDescriptions = $this->descriptionRepository->getById($product->getId());
            $extensionAttributes->setCustomProductDescription($customDescriptions);
            $product->setExtensionAttributes($extensionAttributes);
        }

        return $this;
    }
}
