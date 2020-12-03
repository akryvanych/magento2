<?php
declare(strict_types = 1);

namespace My\CustomDescription\Plugin;

use Magento\Customer\Api\Data\CustomerInterface;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Add description to Customer
 */
class AddAllowDescriptionToCustomer
{

    /** @var CustomDescriptionRepository */
    private $customDescriptionRepository;

    /**
     * Repository constructor.
     *
     * @param CustomDescriptionRepository $customDescriptionRepository
     */
    public function __construct(
        CustomDescriptionRepository $customDescriptionRepository
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * Add is allowed descriptions to the new customer.
     *
     * @param CustomerInterface $customer
     * @return self
     * @throws \Exception
     */
    public function addDescriptionsToNewCustomer(CustomerInterface $customer)
    {
        $customerEmail = $customer->getEmail();
        $isAllowed     = $this->customDescriptionRepository->getIsAllowedByEmail($customerEmail);
        if ($isAllowed == '0') {
            $extensionAttributes = $customer->getExtensionAttributes();
            $extensionAttributes->setIsAllowedDescription(false);
            $customer->setExtensionAttributes($extensionAttributes);
        }

        return $this;
    }
}
