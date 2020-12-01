<?php
declare(strict_types=1);

namespace My\CustomDescription\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\App\ResourceConnection;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;
use My\CustomDescription\Api\Data\CustomDescriptionSearchResultInterface;
use My\CustomDescription\Api\Data\CustomDescriptionSearchResultInterfaceFactory;
use My\CustomDescription\Model\ResourceModel\CustomDescriptions\CollectionFactory;

/**
 * Custom Description repository.
 */
class CustomDescriptionRepository implements CustomDescriptionRepositoryInterface
{
    /** @var string */
    public const DESCRIPTION_TABLE = 'allow_add_description';

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var CustomDescriptionSearchResultInterfaceFactory
     */
    private $customDescriptionSearchResultInterfaceFactory;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /** @var ResourceConnection */
    private $resourceConnection;

    /**
     * @param CollectionProcessorInterface                  $collectionProcessor
     * @param CustomDescriptionSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory
     * @param CollectionFactory                             $collectionFactory
     * @param ResourceConnection                            $resourceConnection
     * @param SearchCriteriaBuilder                         $searchCriteriaBuilder
     */
    public function __construct(
        CollectionProcessorInterface $collectionProcessor,
        CustomDescriptionSearchResultInterfaceFactory $customDescriptionSearchResultInterfaceFactory,
        CollectionFactory $collectionFactory,
        ResourceConnection $resourceConnection,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->collectionProcessor                           = $collectionProcessor;
        $this->customDescriptionSearchResultInterfaceFactory = $customDescriptionSearchResultInterfaceFactory;
        $this->collectionFactory                             = $collectionFactory;
        $this->resourceConnection                            = $resourceConnection;
        $this->searchCriteriaBuilder                         = $searchCriteriaBuilder;
    }

    /**
     * Save attribute
     *
     * @param string $customerEmail
     * @param bool $currentIsAllowedDescription
     * @return CustomDescriptionInterface|void
     */
    public function save(
        string $customerEmail,
        bool $currentIsAllowedDescription
    ) {
        $connection = $this->resourceConnection->getConnection();
        $tableName  = $connection->getTableName(self::DESCRIPTION_TABLE);
        $insertData =
        ["is_allowed_description" => $currentIsAllowedDescription, 'customer_email' => $customerEmail];
        $connection->insertOnDuplicate($tableName, $insertData);
    }

    /**
     * Get list of allow descriptions
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CustomDescriptionSearchResultInterface|void
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

    /**
     * Get attribute is_allowed_description by email
     *
     * @param string $customerEmail
     * @return bool|void
     */
    public function getIsAllowedByEmail(string $customerEmail)
    {
        $searchCriteriaBuilder = $this->searchCriteriaBuilder->addFilter(
            'customer_email',
            "$customerEmail"
        )->create();
        $descriptions = $this->getList($searchCriteriaBuilder)->getItems();
        $result = [];
        array_walk(
            $descriptions,
            function ($description) use (&$result) {
                $result[$description->getCustomerEmail()] = $description->isAllowedDescription();
            }
        );
        return $result[$customerEmail];
    }
}
