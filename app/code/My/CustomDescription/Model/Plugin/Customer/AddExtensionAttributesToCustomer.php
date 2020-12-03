<?php
declare(strict_types=1);

namespace My\CustomDescription\Model\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use My\CustomDescription\Plugin\AddAllowDescriptionToCustomer;

/**
 * Add Extension Attributes After Get plugin
 */
class AddExtensionAttributesToCustomer
{
    /** @var AddAllowDescriptionToCustomer */
    private $addAllowDescription;

    /**
     * AddExtensionAttributesAfterGet constructor.
     *
     * @param AddAllowDescriptionToCustomer $addAllowDescription
     */
    public function __construct(
        AddAllowDescriptionToCustomer $addAllowDescription
    ) {
        $this->addAllowDescription = $addAllowDescription;
    }

    /**
     * After get plugin.
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface
     * @throws \Exception
     */
    public function afterGet(
        CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ) {
        $this->addAllowDescription->addDescriptionsToNewCustomer($customer);
        return $customer;
    }
}
