<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use My\CustomDescription\Model\CustomDescriptionRepository;
use My\CustomDescription\Plugin\AddAllowDescriptionToCustomer;

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

    /** @var AddAllowDescriptionToCustomer */
    private $addAllowDescriptionToCustomer;

    /**
     * Plugin constructor.
     *
     * @param SearchCriteriaInterface       $searchCriteriaInterface
     * @param CustomDescriptionRepository   $customDescriptionRepository
     * @param SearchCriteriaBuilder         $searchCriteriaBuilder
     * @param AddAllowDescriptionToCustomer $addAllowDescriptionToCustomer
     */
    public function __construct(
        SearchCriteriaInterface $searchCriteriaInterface,
        CustomDescriptionRepository $customDescriptionRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        AddAllowDescriptionToCustomer $addAllowDescriptionToCustomer
    ) {
        $this->searchCriteriaInterface     = $searchCriteriaInterface;
        $this->searchCriteriaBuilder       = $searchCriteriaBuilder;
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->addAllowDescriptionToCustomer = $addAllowDescriptionToCustomer;
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
                $customerData['customer']['extension_attributes']['is_allowed_description'] = (string)(int)$isAllowed;
            }
        }

        return $data;
    }
}
