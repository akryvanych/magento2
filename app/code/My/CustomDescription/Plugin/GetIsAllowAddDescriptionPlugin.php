<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use Magento\Framework\Api\SearchCriteriaInterface;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Get is allow add description plugin class.
 */
class GetIsAllowAddDescriptionPlugin
{

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteriaInterface;

    /**
     * @var CustomDescriptionRepository
     */
    private $customDescriptionRepository;

    /**
     * Plugin constructor.
     *
     * @param SearchCriteriaInterface $searchCriteriaInterface
     * @param CustomDescriptionRepository $customDescriptionRepository
     */
    public function __construct(
        SearchCriteriaInterface $searchCriteriaInterface,
        CustomDescriptionRepository $customDescriptionRepository
    ) {
        $this->searchCriteriaInterface = $searchCriteriaInterface;
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Add custom data to customer data.
     *
     * @param DataProviderWithDefaultAddresses $subject
     * @param array $data
     * @return array
     */
    public function afterGetData(DataProviderWithDefaultAddresses $subject, array $data)
    {
        $searchCriteriaInterface = $this->searchCriteriaInterface;
        $descriptions = $this->customDescriptionRepository->getList($searchCriteriaInterface)->getItems();
        array_walk($descriptions, function ($description) use (&$result) {
            $result[$description->getCustomerEmail()] = $description->getIsAllowedDescription();
        });

        foreach ($data as &$customerData) {
            $email = $customerData['customer']['email'] ?? '';
            if ($email && isset($result[$email])) {
                $customerData['customer']['is_allowed_description'] = (string)(int)$result[$email];
            }
        }

        return $data;

    }
}
