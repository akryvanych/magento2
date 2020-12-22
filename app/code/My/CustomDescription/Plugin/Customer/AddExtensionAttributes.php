<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin\Customer;

use Exception;
use Magento\Customer\Api\Data\CustomerInterface;
use My\CustomDescription\Model\CustomDescriptionRepository;
use Magento\Customer\Api\Data\CustomerExtensionFactory;

/**
 * Class Get allow add description to customer
 */
class AddExtensionAttributes
{

    /**
     * @var CustomerExtensionFactory
     */
    private $customerExtensionFactory;

    /**
     * @var CustomDescriptionRepository
     */
    private $customDescriptionRepository;

    /**
     * @param CustomDescriptionRepository $customDescriptionRepository
     * @param CustomerExtensionFactory    $customerExtensionFactory
     */
    public function __construct(
        CustomDescriptionRepository $customDescriptionRepository,
        CustomerExtensionFactory $customerExtensionFactory
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
        $this->customerExtensionFactory = $customerExtensionFactory;
    }

    /**
     * Get Extension attributes data
     *
     * @param CustomerInterface $customer
     *
     * @return CustomerInterface
     * @throws Exception
     */
    public function getCustomerData(CustomerInterface $customer): CustomerInterface
    {
        $extensionAttributes = $customer->getExtensionAttributes() ?? $this->customerExtensionFactory->create();
        if ($extensionAttributes->getIsAllowedDescription() !== null) {
            return $customer;
        }
        $customerEmail = $customer->getEmail();
        $isAllowed = $this->customDescriptionRepository->getByEmail($customerEmail);
        $extensionAttributes->setIsAllowedDescription($isAllowed);
        $customer->setExtensionAttributes($extensionAttributes);

        return $customer;
    }
}
