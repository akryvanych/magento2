<?php
declare(strict_types=1);

namespace My\CustomDescription\Plugin\Customer;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Add Allow Description after get by id
 */
class AfterGetByIdAddAllowDescription
{

    /**
     * @var GetCustomData
     */
    private $getCustomData;

    /**
     * @param GetCustomData $getCustomData
     */
    public function __construct(
        GetCustomData $getCustomData
    ) {
        $this->getCustomData = $getCustomData;
    }

    /**
     * After get by id plugin.
     *
     * @param CustomerRepositoryInterface $subject
     * @param CustomerInterface           $customer
     * @return CustomerInterface
     */
    public function afterGetById(
        CustomerRepositoryInterface $subject,
        CustomerInterface $customer
    ): CustomerInterface {
        $this->getCustomData->getCustomerData($customer);
        return $customer;
    }
}
