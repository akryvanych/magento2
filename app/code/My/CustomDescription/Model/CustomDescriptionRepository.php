<?php
declare(strict_types = 1);

namespace My\CustomDescription\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;
use My\CustomDescription\Api\Data\CustomDescriptionSearchResultInterface;
use My\CustomDescription\Api\Data\CustomDescriptionSearchResultInterfaceFactory;
use My\CustomDescription\Model\ResourceModel\CustomDescription;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use My\CustomDescription\Model\ResourceModel\CustomDescriptions\CollectionFactory;

/**
 * Custom Description repository.
 */
class CustomDescriptionRepository implements CustomDescriptionRepositoryInterface
{
    /**
     * @var CustomDescriptionFactory
     */
    private $customDescriptionFactory;

    /**
     * @var CustomDescriptionInterface
     */
    private $customDescriptionInterface;

    /**
     * @var CustomDescription
     */
    private $customDescriptionResourceModel;

    /**
     * @var CustomDescriptionSearchResultInterfaceFactory
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
     * @param CustomDescriptionInterface                    $customDescriptionInterface
     * @param CustomDescriptionFactory                      $customDescriptionFactory
     * @param CustomDescriptionSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory
     * @param CollectionProcessorInterface                  $collectionProcessor
     * @param CustomDescription                             $customDescriptionResourceModel
     * @param CollectionFactory                             $collectionFactory
     */
    public function __construct(
        CustomDescriptionInterface $customDescriptionInterface,
        CustomDescriptionFactory $customDescriptionFactory,
        CustomDescriptionSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory,
        CollectionProcessorInterface $collectionProcessor,
        CustomDescription $customDescriptionResourceModel,
        CollectionFactory $collectionFactory
    ) {
        $this->customDescriptionInterface                    = $customDescriptionInterface;
        $this->customDescriptionFactory                      = $customDescriptionFactory;
        $this->customDescriptionSearchResultInterfaceFactory = $customDescriptionSearchResultInterfaceFactory;
        $this->collectionProcessor                           = $collectionProcessor;
        $this->customDescriptionResourceModel                = $customDescriptionResourceModel;
        $this->collectionFactory                             = $collectionFactory;
    }

    /**
     * Save CustomDescriptionInterface
     *
     * @param CustomDescriptionInterface $customDescription
     * @return void
     * @throws AlreadyExistsException
     */
    public function save(CustomDescriptionInterface $customDescription)
    {
        $this->customDescriptionResourceModel->save($customDescription);
    }

    /**
     * Get CustomDescriptionInterface by customer email
     *
     * @param string $customerEmail
     * @return CustomDescriptionInterface
     * @throws NoSuchEntityException
     */
    public function getByEmail(string $customerEmail): CustomDescriptionInterface
    {
        $object = $this->customDescriptionFactory->create();
        $this->customDescriptionResourceModel->load($object, $customerEmail, 'customer_email');
        if (empty($object->getId() ?? $customerEmail)) {
            throw new NoSuchEntityException(
                __(
                    'Customer with email "%1" does not exist.',
                    $customerEmail
                )
            );
        }
        $customDescriptionInterface = $this->customDescriptionInterface;
        $customDescriptionInterface->setCustomerEmail($customerEmail);
        $customDescriptionInterface->setIsAllowedDescription(
            $object->getIsAllowedDescription()
            ?? false
        );

        return $customDescriptionInterface;
    }

    /**
     * Get list of allow descriptions
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionSearchResultInterface $searchResult
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CustomDescriptionSearchResultInterface
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
