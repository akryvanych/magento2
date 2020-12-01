<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Get is allow add description plugin class.
 */
class GetIsAllowAddDescription
{

    /** @var SearchCriteriaInterface */
    private $searchCriteriaInterface;

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var CustomDescriptionRepository */
    private $customDescriptionRepository;

    /** @var Customer */
    private $customer;

    /**
     * Plugin constructor.
     *
     * @param SearchCriteriaInterface       $searchCriteriaInterface
     * @param CustomDescriptionRepository   $customDescriptionRepository
     * @param SearchCriteriaBuilder         $searchCriteriaBuilder
     * @param Customer                      $customer
     */
    public function __construct(
        Customer $customer,
        SearchCriteriaInterface $searchCriteriaInterface,
        CustomDescriptionRepository $customDescriptionRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->customer = $customer;
        $this->searchCriteriaInterface     = $searchCriteriaInterface;
        $this->searchCriteriaBuilder       = $searchCriteriaBuilder;
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Add custom data to customer data.
     *
     * @param DataProviderWithDefaultAddresses $subject
     * @param array                            $data
     * @return array
     */
    public function afterGetData(DataProviderWithDefaultAddresses $subject, array $data)
    {
        $customerEmail = current($data)['customer']['email'];
        $isAllowed = $this->customDescriptionRepository->getIsAllowedByEmail($customerEmail);
        foreach ($data as &$customerData) {
            $email = $customerData['customer']['email'] ?? '';
            if ($email && isset($isAllowed)) {
                $customerData['customer']['is_allowed_description'] = (string)(int)$isAllowed;
            }
        }

        return $data;
    }
}
