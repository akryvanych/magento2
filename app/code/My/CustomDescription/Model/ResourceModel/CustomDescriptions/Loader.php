<?php

declare(strict_types=1);

namespace My\CustomDescription\Model\ResourceModel\CustomDescriptions;

use Exception;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\EntityManager\MetadataPool;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

/**
 * Class Loader
 */
class Loader
{
    /** @var  MetadataPool */
    private $metadataPool;

    /** @var  ResourceConnection\ */
    private $resourceConnection;

    /**
     * @param MetadataPool $metadataPool
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        MetadataPool $metadataPool,
        ResourceConnection $resourceConnection
    ) {
        $this->metadataPool = $metadataPool;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param $customerEmail
     * @return array
     * @throws Exception
     */
    public function getCustomersByCustomerEmails(string $customerEmail): string
    {
        $metadata = $this->metadataPool->getMetadata(CustomDescriptionInterface::class);
        $connection = $this->resourceConnection->getConnection();
        $select = $connection
            ->select()
            ->from($metadata->getEntityTable(), CustomDescriptionInterface::CUSTOMER_EMAIL)
            ->where(CustomDescriptionInterface::CUSTOMER_EMAIL . ' = ?', $customerEmail);
        $email = $connection->fetchCol($select);
        if (!empty($email)) {
            return $email[0];
        } else {
            return $email = 'new_user';
        }
    }
}
