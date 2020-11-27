<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace My\CustomDescription\Model\Plugin\Customer;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\EntityManager\EntityManager;
use My\CustomDescription\Model\CustomDescriptionRepository;
use My\CustomDescription\Model\CustomDescriptionFactory;

/**
 * Custom Description Repository plugin class.
 */
class Repository
{


    /** @var SearchCriteriaInterface */
    private $searchCriteriaInterface;

    /** @var CustomDescriptionRepository */
    private $customDescriptionRepository;

    /** @var  EntityManager */
    private $entityManager;

    /** @var CustomDescriptionFactory */
    private $customDescriptionFactory;

    /**
     * Repository constructor.
     * @param SearchCriteriaInterface $searchCriteriaInterface
     * @param CustomDescriptionRepository $customDescriptionRepository
     * @param EntityManager $entityManager
     * @param CustomDescriptionFactory $customDescriptionFactory
     */
    public function __construct(
        SearchCriteriaInterface $searchCriteriaInterface,
        CustomDescriptionRepository $customDescriptionRepository,
        EntityManager $entityManager,
        CustomDescriptionFactory $customDescriptionFactory
    ) {
        $this->searchCriteriaInterface = $searchCriteriaInterface;
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->entityManager = $entityManager;
        $this->customDescriptionFactory = $customDescriptionFactory;
    }

    /**
     * Add switch of custom descriptions to customer extension attributes
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param \Magento\Framework\Api\SearchResults $searchResult
     * @return \Magento\Framework\Api\SearchResults
     * @throws \Exception
     */
    public function afterGetList(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Framework\Api\SearchResults $searchResult
    ) {
        /** @var \Magento\Customer\Api\Data\CustomerInterface $customer */
        foreach ($searchResult->getItems() as $customer) {
            $this->addDescriptionsToCustomer($customer);
        }

        return $searchResult;
    }

    /**
     * Before save plugin.
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @return void
     */
    public function beforeSave(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    ) {
        $this->currentCustomer = $customer;
    }

    /**
     * After get plugin.
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface
     * @throws \Exception
     */
    public function afterGet(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    ) {
        $this->addDescriptionsToCustomer($customer);
        return $customer;
    }

    /**
     * Add is allowed custom descriptions to the current customer.
     *
     * @param CustomerInterface $customer
     * @return self
     * @throws \Exception
     */
    private function addDescriptionsToCustomer(\Magento\Customer\Api\Data\CustomerInterface $customer)
    {
        $extensionAttributes = $customer->getExtensionAttributes();
        $customerEmail = $customer->getEmail();
        $searchCriteriaInterface = $this->searchCriteriaInterface;
        $descriptions = $this->customDescriptionRepository->getList($searchCriteriaInterface)->getItems();
        $isAllowedDescription = $descriptions[$customerEmail] ?? '';
        if (!empty($descriptions[$customerEmail])) {
            $extensionAttributes->setAllowAddDescription($isAllowedDescription);
            $customer->setExtensionAttributes($extensionAttributes);
            return $this;
        } else {
            $customDescription = $this->customDescriptionFactory->create();
            $customDescriptions = $this->entityManager->load($customDescription, $customerEmail);
            $customDescriptions->setCustomerEmail($customerEmail);
            $extensionAttributes->setAllowAddDescription($customDescriptions);
            $customer->setExtensionAttributes($extensionAttributes);
            return $this;
        }
    }
}
