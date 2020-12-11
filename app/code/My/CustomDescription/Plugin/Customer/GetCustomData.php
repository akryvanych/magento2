<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin\Customer;

use Magento\Customer\Api\Data\CustomerInterface;
use My\CustomDescription\Model\CustomDescriptionRepository;

/**
 * Class Get allow add description to customer
 */
class GetCustomData
{

    private $_customerExtensionFactory;

    /**
     * @var CustomDescriptionRepository
     */
    private $customDescriptionRepository;

    /**
     * @param CustomDescriptionRepository $customDescriptionRepository
     */
    public function __construct(
        CustomDescriptionRepository $customDescriptionRepository
    ) {
        $this->customDescriptionRepository = $customDescriptionRepository;
    }

    /**
     * @param CustomerInterface $customer
     *
     * @return CustomerInterface
     */
    public function getCustomerData(CustomerInterface $customer): CustomerInterface
    {
        $customerEmail = $customer->getEmail();
        $customerData = $customer->getExtensionAttributes()->getIsAllowedDescription() ??
            $this->customDescriptionRepository->getByEmail($customerEmail);
        $extensionAttributes = $customer->getExtensionAttributes() ?? '';
        $customerExtension = $extensionAttributes ? $extensionAttributes : $this->_customerExtensionFactory->create();
        $customerExtension->setIsAllowedDescription($customerData);
        $customer->setExtensionAttributes($customerExtension);

        return $customer;
    }
}
