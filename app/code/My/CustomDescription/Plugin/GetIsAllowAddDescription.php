<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Model\Customer\DataProviderWithDefaultAddresses;
use Magento\Framework\Api\SearchCriteriaBuilderFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use My\CustomDescription\Api\CustomDescriptionRepositoryInterface;

/**
 * Get is allow add description for customer form.
 */
class GetIsAllowAddDescription
{

    /** @var CustomDescriptionRepositoryInterface */
    private $customDescriptionRepository;

    /** @var SearchCriteriaInterface */
    private $searchCriteriaInterface;

    /** @var SearchCriteriaBuilderFactory */
    private $searchCriteriaBuilder;

    /**
     * Plugin constructor.
     *
     * @param SearchCriteriaInterface              $searchCriteriaInterface
     * @param CustomDescriptionRepositoryInterface $customDescriptionRepository
     * @param SearchCriteriaBuilderFactory         $searchCriteriaBuilder
     */
    public function __construct(
        SearchCriteriaInterface $searchCriteriaInterface,
        CustomDescriptionRepositoryInterface $customDescriptionRepository,
        SearchCriteriaBuilderFactory $searchCriteriaBuilder
    ) {
        $this->searchCriteriaInterface     = $searchCriteriaInterface;
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->searchCriteriaBuilder       = $searchCriteriaBuilder;
    }

    /**
     * Add custom data to customer data.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param DataProviderWithDefaultAddresses $subject
     * @param array                            $data
     * @return array
     */
    public function afterGetData(DataProviderWithDefaultAddresses $subject, array $data): array
    {
        if (!empty($data)) {
            $customerEmails = [];
            foreach ($data as $customerData) {
                $customerEmail                  = $customerData['customer']['email'] ?? null;
                $customerEmails[$customerEmail] = $customerEmail;
            }
            $customerCriteriaBuilder = $this->searchCriteriaBuilder->create();
            $customerCriteriaBuilder->addFilter('customer_email', $customerEmails, 'in');
            $customerSearchCriteria = $customerCriteriaBuilder->create();
            $descriptions           = $this->customDescriptionRepository->getList($customerSearchCriteria)->getItems();
            array_walk(
                $descriptions,
                static function ($description) use (&$result) {
                    $result[$description->getCustomerEmail()] = $description->getIsAllowedDescription();
                }
            );
            foreach ($data as &$customerData) {
                $email = $customerData['customer']['email'] ?? null;
                if (isset($result[$email])) {
                    $isAllowed = $result[$email];
                    $customerData['customer']['extension_attributes']['is_allowed_description'] =
                        (string) (int) $isAllowed;
                }
            }
        }

        return $data;
    }
}
