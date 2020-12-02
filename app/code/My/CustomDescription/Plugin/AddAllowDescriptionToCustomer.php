<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\EntityManager\EntityManager;
use My\CustomDescription\Model\CustomDescriptionFactory;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Add description to Customer
 */
class AddAllowDescriptionToCustomer
{
    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var CustomDescriptionRepository */
    private $customDescriptionRepository;

    /** @var  EntityManager */
    private $entityManager;

    /** @var CustomDescriptionFactory */
    private $customDescriptionFactory;

    /**
     * Repository constructor.
     *
     * @param SearchCriteriaBuilder       $searchCriteriaBuilder
     * @param CustomDescriptionRepository $customDescriptionRepository
     * @param EntityManager               $entityManager
     * @param CustomDescriptionFactory    $customDescriptionFactory
     */
    public function __construct(
        SearchCriteriaBuilder $searchCriteriaBuilder,
        CustomDescriptionRepository $customDescriptionRepository,
        EntityManager $entityManager,
        CustomDescriptionFactory $customDescriptionFactory
    ) {
        $this->searchCriteriaBuilder       = $searchCriteriaBuilder;
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->entityManager               = $entityManager;
        $this->customDescriptionFactory    = $customDescriptionFactory;
    }

    /**
     * Add is allowed custom descriptions to the current customer.
     *
     * @param CustomerInterface $customer
     * @return self
     * @throws \Exception
     */
    public function addDescriptionsToCustomer(CustomerInterface $customer)
    {
        $extensionAttributes     = $customer->getExtensionAttributes();
        $customerEmail           = $customer->getEmail();
        $isAllowed = $this->customDescriptionRepository->getIsAllowedByEmail($customerEmail);
        if ($isAllowed != 0) {
            $extensionAttributes->setAllowAddDescription($isAllowed);
        } else {
            $extensionAttributes->setAllowAddDescription(false);
        }
        $customer->setExtensionAttributes($extensionAttributes);
        return $this;
    }
}
