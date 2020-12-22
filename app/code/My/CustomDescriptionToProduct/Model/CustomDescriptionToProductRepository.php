<?php
declare(strict_types=1);

namespace My\CustomDescriptionToProduct\Model;

use Exception;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use My\CustomDescriptionToProduct\Api\CustomDescriptionToProductRepositoryInterface;
use My\CustomDescriptionToProduct\Api\Data\CustomDescriptionToProductInterface;
use My\CustomDescriptionToProduct\Api\Data\CustomDescriptionToProductSearchResultInterface;
use My\CustomDescriptionToProduct\Api\Data\CustomDescriptionToProductSearchResultInterfaceFactory;
use My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionsToProduct\CollectionFactory;
use My\CustomDescriptionToProduct\Model\ResourceModel\CustomDescriptionToProduct;

/**
 * Custom Description repository.
 */
class CustomDescriptionToProductRepository implements CustomDescriptionToProductRepositoryInterface
{
    /**
     * @var CustomDescriptionToProductFactory
     */
    private $customDescriptionToProductFactory;

    /**
     * @var CustomDescriptionToProduct
     */
    private $customDescriptionResourceModel;

    /**
     * @var CustomDescriptionToProductSearchResultInterfaceFactory
     */
    private $customDescriptionSearchResultInterfaceFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SearchCriteriaBuilderFactory
     */
    private $searchCriteriaBuilderFactory;

    /**
     * @param CustomDescriptionToProductFactory                      $customDescriptionToProductFactory
     * @param CustomDescriptionToProductSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory
     * @param CollectionProcessorInterface                           $collectionProcessor
     * @param CustomDescriptionToProduct                             $customDescriptionResourceModel
     * @param CollectionFactory                                      $collectionFactory
     * @param SearchCriteriaBuilderFactory                           $searchCriteriaBuilderFactory
     */
    public function __construct(
        CustomDescriptionToProductFactory $customDescriptionToProductFactory,
        CustomDescriptionToProductSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor,
        CustomDescriptionToProduct $customDescriptionResourceModel,
        CollectionFactory $collectionFactory,
        SearchCriteriaBuilderFactory $searchCriteriaBuilderFactory
    ) {
        $this->customDescriptionToProductFactory             = $customDescriptionToProductFactory;
        $this->customDescriptionSearchResultInterfaceFactory = $customDescriptionSearchResultInterfaceFactory;
        $this->collectionProcessor                           = $collectionProcessor;
        $this->customDescriptionResourceModel                = $customDescriptionResourceModel;
        $this->collectionFactory                             = $collectionFactory;
        $this->searchCriteriaBuilderFactory                  = $searchCriteriaBuilderFactory;
    }

    /**
     * Save CustomDescriptionInterface
     *
     * @param CustomDescriptionToProductInterface $customDescriptionToProduct
     * @return void
     * @throws AlreadyExistsException
     */
    public function save(CustomDescriptionToProductInterface $customDescriptionToProduct): void
    {
        $this->customDescriptionResourceModel->save($customDescriptionToProduct);
    }

    /**
     * Delete CustomDescriptionInterface
     *
     * @param CustomDescriptionToProductInterface $customDescriptionToProduct
     * @return void
     * @throws Exception
     */
    public function delete(CustomDescriptionToProductInterface $customDescriptionToProduct): void
    {
        $this->customDescriptionResourceModel->delete($customDescriptionToProduct);
    }

    /**
     * Get CustomDescriptionInterface by product id
     *
     * @param int $productId
     * @return array
     * @throws Exception
     */
    public function getById(int $productId): array
    {
        $customerCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $customerCriteriaBuilder->addFilter('product_id', $productId, 'in');
        $customerCriteriaBuilder->addFilter('is_approved', '1', 'in');
        $customerSearchCriteria = $customerCriteriaBuilder->create();
        return $this->getList($customerSearchCriteria)->getItems();
    }

    /**
     * Get CustomDescriptionToProductInterface by comment id.
     *
     * @param string $commentId
     * @return array
     */
    public function getCommentByCommentId(string $commentId): array
    {
        $customerCriteriaBuilder = $this->searchCriteriaBuilderFactory->create();
        $customerCriteriaBuilder->addFilter('comment_id', $commentId, 'in');
        $customerSearchCriteria = $customerCriteriaBuilder->create();
        return $this->getList($customerSearchCriteria)->getItems();
    }

    /**
     * Get list of CustomDescriptionToProductInterface
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionToProductSearchResultInterface
     */
    public function getList(
        SearchCriteriaInterface $searchCriteria
    ): CustomDescriptionToProductSearchResultInterface {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->customDescriptionSearchResultInterfaceFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
