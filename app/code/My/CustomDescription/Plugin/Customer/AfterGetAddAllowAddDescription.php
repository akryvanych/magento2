<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin\Customer;

use Exception;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Class AfterGetAddAllowAddDescription
 */
class AfterGetAddAllowAddDescription
{
    /**
     * @var AddExtensionAttributes
     */
    private $addExtensionAttributes;

    /**
     * @param AddExtensionAttributes $addExtensionAttributes
     */
    public function __construct(
        AddExtensionAttributes $addExtensionAttributes
    ) {
        $this->addExtensionAttributes = $addExtensionAttributes;
    }

    /**
     * After get by id plugin.
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $customer
     * @return CustomerInterface
     * @throws Exception
     * @SuppressWarnings("unused")
     */
    public function afterGet(
        CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ): CustomerInterface {
        $this->addExtensionAttributes->getCustomerData($customer);
        return $customer;
    }
}
