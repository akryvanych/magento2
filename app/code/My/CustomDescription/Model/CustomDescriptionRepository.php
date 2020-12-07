<?php
declare(strict_types = 1);

namespace My\CustomDescription\Model;

use Magento\Framework\App\ResourceConnection;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;
use My\CustomDescription\Model\CustomDescription as CustomDescriptionModel;
use My\CustomDescription\Model\ResourceModel\CustomDescription;

/**
 * Custom Description repository.
 */
class CustomDescriptionRepository implements CustomDescriptionRepositoryInterface
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var CustomDescription
     */
    private $customDescription;

    /**
     * @var CustomDescriptionModel
     */
    private $customDescriptionModel;

    /**
     * @var CustomDescriptionInterface
     */
    private $customDescriptionInterface;

    /**
     * @param ResourceConnection                            $resourceConnection
     * @param CustomDescription                             $customDescription
     * @param CustomDescriptionModel                        $customDescriptionModel
     * @param CustomDescriptionInterface                    $customDescriptionInterface
     */
    public function __construct(
        ResourceConnection $resourceConnection,
        CustomDescription $customDescription,
        CustomDescriptionModel $customDescriptionModel,
        CustomDescriptionInterface $customDescriptionInterface
    ) {
        $this->resourceConnection                            = $resourceConnection;
        $this->customDescription                             = $customDescription;
        $this->customDescriptionModel                        = $customDescriptionModel;
        $this->customDescriptionInterface                    = $customDescriptionInterface;
    }

    /**
     * Save CustomDescriptionInterface
     *
     * @param CustomDescriptionInterface $customDescription
     * @return void
     */
    public function save(CustomDescriptionInterface $customDescription)
    {
        $currentIsAllowedDescription = $customDescription->getIsAllowedDescription();
        $customerEmail = $customDescription->getCustomerEmail();
        $connection = $this->resourceConnection->getConnection();
        $tableName  = $connection->getTableName('allow_add_description');
        $insertData =
            ["is_allowed_description" => $currentIsAllowedDescription, 'customer_email' => $customerEmail];
        $connection->insertOnDuplicate($tableName, $insertData);
    }

    /**
     * Get CustomDescriptionInterface by customer email
     *
     * @param string $customerEmail
     * @return CustomDescriptionInterface
     */
    public function getByEmail(string $customerEmail): CustomDescriptionInterface
    {
        $object = $this->customDescriptionModel;
        $this->customDescription->load($object, $customerEmail, 'customer_email');
        if (empty($object->getData())) {
            $object->setIsAllowedDescription(false);
            $object->setCustomerEmail($customerEmail);
        }
        $customDescriptionInterface = $this->customDescriptionInterface;
        $customDescriptionInterface->setCustomerEmail($object->getData()['customer_email']);
        $customDescriptionInterface->setIsAllowedDescription((bool)$object->getData()['is_allowed_description']) ?? '';

        return $customDescriptionInterface;
    }
}
