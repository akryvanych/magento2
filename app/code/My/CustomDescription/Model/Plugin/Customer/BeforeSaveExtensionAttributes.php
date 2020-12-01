<?php
declare(strict_types=1);

namespace My\CustomDescription\Model\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Before save extension attributes plugin
 */
class BeforeSaveExtensionAttributes
{

    /**
     * Before save
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface $customer
     *
     * @return void
     */
    public function beforeSave(
        CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ) {
        $this->currentCustomer = $customer;
    }
}
