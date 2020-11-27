<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\ResourceConnection;

/**
 * Set is allow add description plugin class.
 */
class SetIsAllowAddDescriptionPlugin
{
    /**
     * @var Http
     */
    private $request;

    /**
     * @var string
     */
    public const DESCRIPTION_TABLE = 'allow_add_description';

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * Plugin constructor.
     *
     * @param Http $request
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        Http $request,
        ResourceConnection $resourceConnection
    ) {
        $this->request = $request;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * Saving extension value - 'is_allowed_description'
     *
     * @param CustomerRepository $subject
     * @param $data
     * @return mixed
     */
    public function afterSave(CustomerRepository $subject, $data)
    {
        $customerExtensionData = $data->getExtensionAttributes()->getAllowAddDescription() ?? $data->setExtensionAttributes();
        if (!empty($customerExtensionData)) {
            $customerEmail = $customerExtensionData->getCustomerEmail();
            $customerIsAllowedDescription = $customerExtensionData->getIsAllowedDescription();
            $currentIsAllowedDescription = $this->request->getParams()['customer']['is_allowed_description'] ?? $customerIsAllowedDescription;

            $connection = $this->resourceConnection->getConnection();
            $tableName = $connection->getTableName(self::DESCRIPTION_TABLE);
            $insertData = ["is_allowed_description" => $currentIsAllowedDescription , 'customer_email' => $customerEmail];
            $connection->insertOnDuplicate($tableName, $insertData);
        }

        return $data;
    }
}
