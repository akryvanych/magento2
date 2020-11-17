<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace My\CustomDescription\Model\Plugin\Customer;

use Magento\Customer\Api\Data\CustomerExtensionFactory;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\EntityManager\EntityManager;
use My\CustomDescription\Api\CustomDescriptionsProviderInterface;
use My\CustomDescription\Api\Data\CustomDescriptionInterface;

/**
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
     * Add extension Attributes to customer
     *
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResults
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
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return \Magento\Customer\Api\Data\CustomerInterface
     */
    public function afterGet(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    ) {
        $this->addDescriptionsToCustomer($customer);
        return $customer;
    }

    /**
     * Compare old and new attributes
     *
     * @param array $newAttrs
     * @param array $oldAttrs
     * @throws \Exception
     */
    private function cleanOldAttrs(array $newAttrs, array $oldAttrs)
    {
        /** @var CustomDescriptionInterface $attr */
        foreach ($newAttrs as $attr) {
            /** @var CustomDescriptionInterface $oldAtrr */
            foreach ($oldAttrs as $oldAttr) {
                if ($oldAttr->getDescription() === $attr->getDescription()) {
                    $this->entityManager->delete($oldAttr);
                }
            }
        }
    }

    /**
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     *@throws \Exception
     */
    public function afterSave(
        \Magento\Customer\Api\CustomerRepositoryInterface $subject,
        \Magento\Customer\Api\Data\CustomerInterface $customer
    ) {
        if ($this->currentCustomer !== null) {
            /** @var CustomerInterface $previosCustomer */
            $extensionAttributes = $this->currentCustomer->getExtensionAttributes();

            if ($extensionAttributes && $extensionAttributes->getCustomDescriptions()) {
                /** @var CustomDescriptionInterface $customDescription */
                $customDescriptions = $extensionAttributes->getCustomDescriptions();
                $oldAttrs = $customer->getExtensionAttributes()->getCustomDescriptions();

                if (is_array($customDescriptions)) {
                    $this->cleanOldAttrs($customDescriptions, $oldAttrs);
                    /** @var CustomDescriptionInterface $attr */
                    foreach ($customDescriptions as $attr) {
                        $attr->setCustomerEmail($customer->getEmail());
                        $this->entityManager->save($attr);
                    }
                }
            }

            $this->currentCustomer = null;
        }

        return $customer;
    }

    /**
     * @param \Magento\Customer\Api\Data\CustomerInterface $customer
     * @return self
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
