<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace My\CustomDescription\Model\ResourceModel\CustomDescriptions;

use Exception;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\EntityManager\MetadataPool;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

/**
 * Class Loader
 * @package My\CustomDescription\Model\CustomDescriptions
 */
class Loader
{
    /** @var  MetadataPool */
    private $metadataPool;

    /** @var  ResourceConnection\ */
    private $resourceConnection;

    /**
     * Loader constructor.
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
    public function getCustomersByCustomerEmails(string $customerEmail): array
    {
        $metadata = $this->metadataPool->getMetadata(CustomDescriptionInterface::class);
        $connection = $this->resourceConnection->getConnection();

        $select = $connection
            ->select()
            ->from($metadata->getEntityTable(), CustomDescriptionInterface::DESCRIPTION_ID)
            ->where(CustomDescriptionInterface::CUSTOMER_EMAIL . ' = ?', $customerEmail);
        $ids = $connection->fetchCol($select);
        return $ids ?: [];
    }
}
