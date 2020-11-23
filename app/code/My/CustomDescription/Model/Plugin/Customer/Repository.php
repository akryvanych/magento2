<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace My\CustomDescription\Model\Plugin\Customer;

use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\EntityManager\EntityManager;
use My\CustomDescription\Api\CustomDescriptionsProviderInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

/**
 * Custom Description Repository plugin class.
 *
 * Class Repository
 * @package My\CustomDescription\Model\Plugin\Customer
 */
class Repository
{
    /** @var CustomerExtensionFactory */
    private $customerExtensionFactory;

    /** @var CustomerInterface  */
    private $currentCustomer;

    /** @var  EntityManager */
    private $entityManager;

    /** @var CustomDescriptionsProviderInterface */
    private $customDescriptionsProvider;

    /**
     * Repository constructor.
     * @param CustomerExtensionFactory $customerExtensionFactory
     * @param EntityManager $entityManager
     * @param CustomDescriptionsProviderInterface $customDescriptionsProvider
     */
    public function __construct(
        CustomerExtensionFactory $customerExtensionFactory,
        EntityManager $entityManager,
        CustomDescriptionsProviderInterface $customDescriptionsProvider
    ) {
        $this->customerExtensionFactory = $customerExtensionFactory;
        $this->entityManager = $entityManager;
        $this->customDescriptionsProvider = $customDescriptionsProvider;
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
     * After save plugin.
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     * @throws \Exception
     */
    public function afterSave(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    ) {
        if ($this->currentCustomer !== null) {
            /** @var CustomerInterface $previosCustomer */
            $extensionAttributes = $this->currentCustomer->getExtensionAttributes();

            if ($extensionAttributes && $extensionAttributes->getCustomDescriptions()) {
                /** @var CustomDescriptionInterface $customDescriptions */
                $customDescriptions = $extensionAttributes->getCustomDescriptions();
                if (is_array($customDescriptions)) {
                    /** @var CustomDescriptionInterface $customDescription */
                    foreach ($customDescriptions as $customDescription) {
                        $customDescription->setCustomerEmail($customer->getEmail());
                        $this->entityManager->save($customDescription);
                    }
                }
            }

            $this->currentCustomer = null;
        }

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

        if (empty($extensionAttributes)) {
            $extensionAttributes = $this->customerExtensionFactory->create();
        }
        $customDescriptions = $this->customDescriptionsProvider->getDescriptions($customer->getEmail());
        $extensionAttributes->setCustomDescriptions($customDescriptions);
        $customer->setExtensionAttributes($extensionAttributes);
        return $this;
    }
}
