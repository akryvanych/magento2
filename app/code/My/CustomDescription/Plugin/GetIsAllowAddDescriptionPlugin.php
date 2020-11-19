<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use Magento\Framework\App\Request\Http;
use My\CustomDescription\Api\CustomDescriptionsProviderInterface;
use Magento\Framework\Api\ExtensibleDataObjectConverter;

/**
 * Get is allow add description class.
 */
class GetIsAllowAddDescriptionPlugin
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
     * Plugin constructor.
     *
     * @param Http $request
     * @param CustomDescriptionsProviderInterface $customDescriptionsProvider
     * @param ExtensibleDataObjectConverter $dataObjectConverter
     */
    public function __construct(
        Http $request,
        CustomDescriptionsProviderInterface $customDescriptionsProvider,
        ExtensibleDataObjectConverter $dataObjectConverter
    ) {
        $this->request = $request;
        $this->customDescriptionsProvider = $customDescriptionsProvider;
        $this->dataObjectConverter = $dataObjectConverter;
    }

    /**
     * Adds extra abilities data in array.
     *
     * @param DataProviderWithDefaultAddresses $subject
     * @param array $data
     * @return array
     */
    public function afterGetData(DataProviderWithDefaultAddresses $subject, array $data)
    {
        $customerEmail = (string)$this->request->getParam('customer_email');
        $customerExtraAttributesObject = $this->customDescriptionsProvider->getDescriptions($customerEmail);
        if (!empty($customerExtraAttributesObject)) {
            $customerExtraAttributes = $this->dataObjectConverter->toFlatArray($customerExtraAttributesObject[0], []);
            if ($customerExtraAttributes['is_allowed_description'] == 1) {
                $data[$customerEmail]['customer']['is_allowed_description'] = '1';
                return $data;
            }
        }
        return $data;
    }
}
