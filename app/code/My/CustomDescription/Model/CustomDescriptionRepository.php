<?php
declare(strict_types=1);

namespace My\CustomDescription\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;
use My\CustomDescription\Api\Data\CustomDescriptionSearchResultInterfaceFactory;
use My\CustomDescription\Model\ResourceModel\CustomDescriptions\CollectionFactory;

/**
 * Custom Description repository.
 */
class CustomDescriptionRepository implements CustomDescriptionRepositoryInterface
{

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CustomDescriptionSearchResultInterfaceFactory
     */
    private $customDescriptionSearchResultInterfaceFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @param CollectionProcessorInterface $collectionProcessor
     * @param CustomDescriptionSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CustomDescriptionSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->customDescriptionSearchResultInterfaceFactory = $customDescriptionSearchResultInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get list of allow descriptions
     * @param SearchCriteriaInterface $searchCriteria
     * @return
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult = $this->customDescriptionSearchResultInterfaceFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
