<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Plugin\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchResults;

/**
 * Add Custom Description after get product list
 */
class AfterGetListCustomProductDescription
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
     * Add Custom Description after get product list
     *
     * @param  ProductRepositoryInterface $subject
     * @param  SearchResults              $searchResult
     * @return SearchResults
     * @SuppressWarnings("unused")
     */
    public function afterGetList(
        ProductRepositoryInterface $subject,
        SearchResults $searchResult
    ): SearchResults {
        /** @var ProductInterface $product */
        foreach ($searchResult->getItems() as $product) {
            $this->addCustomProductDescription->addCustomProductDescription($product);
        }

        return $searchResult;
    }
}
