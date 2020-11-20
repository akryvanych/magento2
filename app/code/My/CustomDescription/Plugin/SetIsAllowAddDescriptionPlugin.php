<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\Api\ExtensibleDataObjectConverter;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;
use My\CustomDescription\Api\CustomDescriptionsProviderInterface;

/**
 * Add is allow add description plugin class.
 */
class SetIsAllowAddDescriptionPlugin
{
    /**
     * @var Http
     */
    private $request;

    /**
     * @var CustomDescriptionsProviderInterface
     */
    private $customDescriptionsProvider;

    /**
     * @var ExtensibleDataObjectConverter
     */
    private $dataObjectConverter;

    /**
     * @var string
     */
    const QUOTE_TABLE = 'allow_add_description';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * Plugin constructor.
     *
     * @param Http $request
     * @param CustomDescriptionsProviderInterface $customDescriptionsProvider
     * @param ExtensibleDataObjectConverter $dataObjectConverter
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Http $request,
        CustomDescriptionsProviderInterface $customDescriptionsProvider,
        ExtensibleDataObjectConverter $dataObjectConverter,
        ResourceConnection $resourceConnection
    ) {
        $this->request = $request;
        $this->customDescriptionsProvider = $customDescriptionsProvider;
        $this->dataObjectConverter = $dataObjectConverter;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Saving extra abilities.
     *
     * @param CustomerRepository $subject
     * @param array $data
     * @return mixed
     */
    public function afterSave(CustomerRepository $subject, $data)
    {
        $customerEmail = $data->getExtensionAttributes()->getCustomDescriptions()[0]->getCustomerEmail();
        $connection = $this->resourceConnection->getConnection();
        $customerExtraAttributesObject = $this->customDescriptionsProvider->getDescriptions($customerEmail);
        if (!empty($customerExtraAttributesObject)) {
            $customerExtraAttributes = $this->dataObjectConverter->toFlatArray($customerExtraAttributesObject[0], []);
            $customer = $this->request->getParams();
            $customerAllowAddDesc = 0;
            if (isset($customer['customer'])) {
                if ($customer['customer']['is_allowed_description'] !== null) {
                    $customerAllowAddDesc = $customer['customer']['is_allowed_description'];
                }
            }
            if ($customerExtraAttributes['is_allowed_description'] !== $customerAllowAddDesc) {
                if ($customer) {
                    $updateData = ["is_allowed_description" => $customer['customer']['is_allowed_description']];
                } else {
                    $updateData = [
                        "is_allowed_description" => $customerExtraAttributes['is_allowed_description'],
                    ];
                }
                $where = ['customer_email = ?' => $customerEmail];
                $tableName = $connection->getTableName(self::QUOTE_TABLE);
                $connection->update($tableName, $updateData, $where);

                return $data;
            }
        } else {
            $insertData = [
                "customer_email" => $customerEmail,
                "is_allowed_description" => 0,
            ];
            $tableName = $connection->getTableName(self::QUOTE_TABLE);
            $connection->insert($tableName, $insertData);

            return $data;
        }

        return $data;
    }
}
